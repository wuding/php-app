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
    const VERSION = '21.8.27';
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
    public static function ip($not_spider, $ip, $ip_ttl)
    {
        if (!$not_spider) {
            return array();
        }
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
            return true;
            http_response_code(400);
            $routeInfo = array(1, 'error/banned', []);
            return array('routeInfo' => $routeInfo, 'ip_ban' => true);
        }
        return array();
    }

    // 通过来源和次数判定垃圾流量
    public static function spam($not_spider, $row)
    {
        if (!$row || !$not_spider) {
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
            return true;
            http_response_code(400);
            $routeInfo = array(1, 'error/banned', []);
            return array('routeInfo' => $routeInfo, 'ip_ban' => true);
        }
        return array();
    }

    // 实例化模型
    public static function var_models($models)
    {
        $var_array = array();
        foreach ($models as $key => $value) {
            $val = null;
            if ($value) {
                $val = new $value;
            }
            $var_array[$key] = $val;
        }
        return $var_array;
    }

    // 黑名单
    public static function ban_ua($ua, $http_user_agent, $ua_ttl, $ua_arr)
    {
        if (!$ua) {
            return false;
        }
        $md5 = md5($http_user_agent);
        $ua_id = $ua->one('id', "md5 = '$md5'", '', 1, $ua_ttl);
        if (in_array($ua_id, $ua_arr)) {
            return true;
        }
        return null;
    }

    // IP 拦截
    public static function ban_ip($addr, $ip, $ua_ttl, $banned_ip_ids)
    {
        global $ip_row;
        if (!$addr) {
            return false;
        }
        $ip_row = $addr->one('id, referer, log', "str = '$ip'", null, 1, $ua_ttl);
        $ip_id = $ip_row ? $ip_row->id : 0;
        if (in_array($ip_id, $banned_ip_ids)) {
            return true;
        }
        return null;
    }

    public static function ban_ip_arr($ip, $ip_arr)
    {
        $result = in_array($ip, $ip_arr);
        return $result;
    }

    public static function ban_all($enables, $ua, $addr, $http_user_agent, $ua_ttl, $ua_arr, $ip, $ip_ttl, $ip_arr, $ip_row, $banned_ip_ids, $not_spider)
    {
        $var_array = array(
            'ban_ua' => array($ua, $http_user_agent, $ua_ttl, $ua_arr),
            'ban_ip' => array($addr, $ip, $ua_ttl, $banned_ip_ids),
            'ban_ip_arr' => array($ip, $ip_arr),
            'spam' => array($not_spider, $ip_row),
            'ip' => array($not_spider, $ip, $ip_ttl),
        );
        $result = $variable = array();
        foreach ($enables as $value) {
            $val = $var_array[$value] ?? null;
            if ($val) {
                $variable[$value] = $val;
            }
        }
        foreach ($variable as $key => $value) {
            $result[$key] = $ret = call_user_func_array(array('\PhpApp\Example\Index', $key), $value);
            if (true === $ret) {
                return true;
            }
        }
        return $result;
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
    #header("Location: ". Glob::conf('host.location') . $request_uri);
    var_dump([$http_host, Glob::conf('host.name'), $remote_addr, $ip, Glob::conf('host.remote_addr')]);
    exit;
}

global $ip_ban, $ip_row;
$ip_ban = $ip_row = null;

$var_array = Index::var_models($models);
extract($var_array);

// IP 会话次数限制
$not_spider = !$remote_addr && !preg_match("/(http|bot|spider|bing)/i", $http_user_agent);
$ban_all = Index::ban_all($enable_ban, $ua, $addr, $http_user_agent, $ua_ttl, $ua_arr, $ip, $ip_ttl, $ip_arr, $ip_row, $banned_ip_ids, $not_spider);
if (true === $ban_all) {
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
    extract(\model\Mem::hash('files', 'files_', 1));
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
