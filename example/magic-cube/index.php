<?php

namespace PhpApp\Example;

use Stat;
use Ext\X\PhpRedis;
use MagicCube\Dispatcher;
use model\Glob;
use model\stat\RemoteAddr;
use model\stat\SessionId;
use model\stat\UserAgent;

class Index
{
    const VERSION = '21.3.27';
    public $dispatcher = null;
    public static $count = 0;

    public function __construct($routeInfo, $httpMethod)
    {
        $this->init($routeInfo, $httpMethod);
    }

    public function init($routeInfo, $httpMethod)
    {
        $config = include ROOT . '/app/module.php';
        $this->dispatcher = $dispatcher = new Dispatcher($routeInfo, $httpMethod);
        $dispatcher->_setVars($config);
    }

    public function dispatch($return = null)
    {
        return $result = $this->dispatcher->dispatch($return);
    }

    public static function session($options, $sname)
    {
        session_set_cookie_params($options);
        session_name($sname);
        session_id(Glob::$sid);
        # 这个不能用，每次都 Set-Cookie
        session_start();
        $count = $_SESSION['count'] ?? 0;
        $sid = $_GET['sid'] ?? null;
        if (!$count) {
            $_SESSION['initial'] = time();
            $_SESSION['count'] = 1;
        } elseif (!$sid) {
            $_SESSION['updated'] = time();
            $_SESSION['count'] = 1 + $count;
        }
        static::$count = $_SESSION['count'];
    }

    // 通过 IP 会话及访问次数判定垃圾流量
    public static function ip($ip, $ip_ttl)
    {
        //=s
        $ip_key = 'TMP_IP:'. $ip;
        $tmp_ip = PhpRedis::get($ip_key);
        if (false === $tmp_ip) {
            $json_ip = array(Glob::$sid);
            $json_ip = json_encode($json_ip);
            $set = PhpRedis::set($ip_key, $json_ip, $ip_ttl);
            return array();
        }
        //=z
        $ip_arr = json_decode($tmp_ip);
        if (!in_array(Glob::$sid, $ip_arr)) {
            $ip_arr[] = Glob::$sid;
            $json_ip = json_encode($ip_arr);
            $set = PhpRedis::set($ip_key, $json_ip, $ip_ttl);
        }
        $count = count($ip_arr);
        //=l
        if (4 < $count && 9 > static::$count) {
            http_response_code(400);
            $routeInfo = array(1, 'error/banned', []);
            return array('routeInfo' => $routeInfo, 'ip_ban' => true);
        }
        return array();
    }

    // 通过来源和次数判定垃圾流量
    public static function spam($row)
    {
        if (!$row) {
            return array();
        }
        $arr = (array) $row;
        foreach ($arr as $key => $value) {
            if (is_numeric($value)) {
                $arr[$key] = (int) $value;
            }
        }
        extract($arr);
        if (-1 === $referer && 50 < $log) {
            http_response_code(400);
            $routeInfo = array(1, 'error/banned', []);
            return array('routeInfo' => $routeInfo, 'ip_ban' => true);
        }
        return array();
    }
}

// 配置
$var_array = Glob::conf('conf');
extract($var_array);
$ua_arr = Glob::conf('banned.ua');
$ip_arr = Glob::conf('banned.ip');
$ua_ttl = Glob::conf('ttl.ua');
$ip_ttl = Glob::conf('ttl.ip');
$ignore_ip = Glob::conf('log.ignore_ip');
$redirect_ua = Glob::conf('log.redirect_ua');
$redirect_path = Glob::conf('log.redirect_path');

// 参数、变量
$http_user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '<err>';
$ip = $_SERVER['REMOTE_ADDR'] ?? null;
$stat = [];
$http_host = $_SERVER['HTTP_HOST'] ?? null;
$request_uri = $_SERVER['REQUEST_URI'] ?? null;

// 允许访问的主机名，客户端 IP 白名单
$remote_addr = in_array($ip, Glob::conf('host.remote_addr'));
if (!in_array($http_host, Glob::conf('host.name')) && !$remote_addr) {
    header("Location: ". Glob::conf('host.location') . $request_uri);
    exit;
}

// 黑名单
$ua = new UserAgent;
$md5 = md5($http_user_agent);
$ua_id = $ua->one('id', "md5 = '$md5'", '', 1, $ua_ttl);
if (in_array($ua_id, $ua_arr) || in_array($ip, $ip_arr)) {
    http_response_code(400);
    $routeInfo = array(1, 'error/banned', []);
    goto __RUN__;
}

// IP 拦截
$addr = new RemoteAddr;
$ip_row = $addr->one('id, referer, log', "str = '$ip'", null, 1, $ua_ttl);
$ip_id = 0;
$ip_ban = null;
if ($ip_row) {
    $ip_id = $ip_row->id;
}
if (in_array($ip_id, $banned_ip_ids)) {
    http_response_code(400);
    $routeInfo = array(1, 'error/banned', []);
    goto __RUN__;
}

Glob::diff('EXAMPLE_START');
// 忽略统计标记
$var_stat = $_GET['stat'] ?? null;
$expire = time() + 864000000;
if (null !== $var_stat) {
    $setcookie = setcookie('stat', $var_stat, $expire, '/');
} else {
    $var_stat = Glob::conf('stat');
}
$var_stat = $_COOKIE['stat'] ?? $var_stat;
$disable_stat = in_array($ip, $ignore_ip) ?: $var_stat;

// 忽略搜索结果索引
$var_index = $_GET['index'] ?? null;
if (null !== $var_index) {
    $setcookie = setcookie('index', $var_index, $expire, '/');
} else {
    $var_index = $_COOKIE['index'] ?? null;
}
Glob::set('index', $var_index ?? Glob::conf('index'));

/*
$host_string = preg_replace("/\.|:/", '_', $http_host ?? 'err');
$host_name = strtoupper($host_string);
*/

// 会话开始
$sname = Glob::conf('session.name');
$options = Glob::conf('session.cookie');
$sess_ttl = Glob::conf('session.ttl');
$sid = $_GET['sid'] ?? null;
Stat::$unique = md5(json_encode($_SERVER));
Glob::$sid = $_COOKIE[$sname] ?? ($sid ?: Stat::$unique);
$null = Glob::conf('session.start') ? Index::session($options, $sname) : null;

// IP 会话次数限制
if (!$remote_addr && !preg_match("/(http|bot|spider|bing)/i", $http_user_agent)) {
    extract(Index::spam($ip_row));
    if (true === $ip_ban) {
        goto __RUN__;
    }
    extract(Index::ip($ip, $ip_ttl));
    if (true === $ip_ban) {
        goto __RUN__;
    }
}

// 排除统计
$request_path = parse_url($uri, PHP_URL_PATH);
if (!preg_match("/^\/(stat|robot)(|\/.*)$/i", $request_path) && !$disable_stat) {
    PhpRedis::select(Glob::conf('redis.stat_dbindex'));
    // 会话处理
    PhpRedis::sAdd("stat_session", Glob::$sid);
    $sess = PhpRedis::get('TMP_SESSION:'. Glob::$sid);
    if (false === $sess) {
        $mod = new SessionId;
        $data = array('md5' => Glob::$sid);
        $sess = $mod->existsWhere($data, null);
        $set = PhpRedis::set('TMP_SESSION:'. Glob::$sid, $sess, $sess_ttl);
    }
    $stat['srv'] = Stat::srv();
    Glob::diff('STAT_SRV');
    $stat['record'] = Stat::record();
    Glob::diff('STAT_RECORD');
    // 禁用转向
    $redirect = true;
    if ($redirect_path && preg_match("/$redirect_path/i", $request_path)) {
        $redirect = false;
    } elseif ($redirect_ua && preg_match("/$redirect_ua/i", $http_user_agent)) {
        $redirect = false;
    }
    $stat['cookie'] = Stat::cookie($redirect, Glob::conf('query'), null, Glob::$sid);
    PhpRedis::db();
    Glob::diff('STAT_COOKIE');
}

__RUN__:
$debug = Glob::conf('debug');
$index = new Index($routeInfo, $httpMethod);
#Glob::diff('EXAMPLE_INIT');
$result = $index->dispatch($debug);
#Glob::diff('EXAMPLE_DISPATCH');
if ($debug) {
    print_r(array($result, $stat, __FILE__, __LINE__));
}

if (null !== $debug) {
    $files = get_included_files();
    // 合并漏掉的
    extract(\Ext\Yac::hash('files', 'files_', 1));
    $cacheValue = is_array($cacheValue) ? $cacheValue : [];
    foreach ($cacheValue as $key => $value) {
        if (!in_array($value, $files)) {
            $files[] = $value;
        }
    }
    // 排序
    if (false === $debug) {
        sort($files);
    }
    print_r(array($files, __FILE__, __LINE__));
}
Glob::diff('EXAMPLE_END');

/* vendor/composer/ClassLoader.php findFile()
extract(Yac::hash('files', 'files_', 1));
$arr = [];
if (false !== $cacheValue) {
    $arr = (array) $cacheValue;
}
$arr[$class] = realpath($file);
Yac::store($cacheKey, $arr, 30, 1);
*/
