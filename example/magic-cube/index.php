<?php

namespace PhpApp\Example;

use Stat;
use Ext\X\PhpRedis;
use MagicCube\Dispatcher;
use model\Glob;
use model\stat\UserAgent;

class Index
{
    const VERSION = '20.213.237';
    public $dispatcher = null;

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
}

// 配置
$ua_arr = Glob::conf('banned.ua');
$ip_arr = Glob::conf('banned.ip');
$ua_ttl = Glob::conf('ttl.ua');
$ignore_ip = Glob::conf('log.ignore_ip');

// 参数、变量
$http_user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '<err>';
$ip = $_SERVER['REMOTE_ADDR'] ?? null;
$ua = new UserAgent;

// 允许访问的主机名，客户端 IP 白名单
$remote_addr = in_array($ip, Glob::conf('host.remote_addr'));
if (!in_array($_SERVER['HTTP_HOST'], Glob::conf('host.name')) && !$remote_addr) {
    header("Location: ". Glob::conf('host.location') . $_SERVER['REQUEST_URI']);
    exit;
}

// 黑名单
$user_agent = addslashes($http_user_agent);
$md5 = md5($user_agent);
$ua_id = $ua->one('id', "md5 = '$md5'", '', 1, $ua_ttl);
if (in_array($ua_id, $ua_arr) || in_array($ip, $ip_arr)) {
    http_response_code(400);
    $routeInfo = array(1, 'error/banned', []);
    goto __RUN__;
}

Glob::diff('EXAMPLE_START');
// 忽略统计标记
$var_stat = $_GET['stat'] ?? null;
if (null !== $var_stat) {
    $expire = time() + 864000000;
    $setcookie = setcookie('stat', $var_stat, $expire, '/');
} else {
    $var_stat = Glob::conf('stat');
}
$var_stat = $_COOKIE['stat'] ?? $var_stat;
$disable_stat = in_array($ip, $ignore_ip) ?: $var_stat;

$host_string = preg_replace("/\.|:/", '_', $_SERVER['HTTP_HOST'] ?? 'err');
$host_name = strtoupper($host_string);
$stat = [];

// 会话开始
$sname = Glob::conf('session.name');
$options = Glob::conf('session.cookie');
$sid = $_GET['sid'] ?? null;
Stat::$unique = md5(json_encode($_SERVER));
Glob::$sid = $_COOKIE[$sname] ?? ($sid ?: Stat::$unique);
session_set_cookie_params($options);
session_name($sname);
session_id(Glob::$sid);
session_start();
$_SESSION['updated'] = time();

// 排除统计
$request_path = parse_url($uri, PHP_URL_PATH);
if (!preg_match("/^\/(stat|robot)(|\/.*)$/i", $request_path) && !$disable_stat) {
    PhpRedis::select(Glob::conf('redis.stat_dbindex'));
    PhpRedis::sAdd("stat_session", Glob::$sid);
    $stat['srv'] = Stat::srv();
    Glob::diff('STAT_SRV');
    $stat['record'] = Stat::record();
    Glob::diff('STAT_RECORD');
    // 禁用转向
    $redirect = true;
    if (preg_match("/^\/(robots|sitemap|play\/sitemap)(|\-\d+)\.(txt|xml|xml\.gz)$/i", $request_path)) {
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
