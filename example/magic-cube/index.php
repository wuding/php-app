<?php

namespace PhpApp\Example;

use Stat;
use Ext\X\PhpRedis;
use MagicCube\Dispatcher;
use model\Glob;

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

Glob::diff('EXAMPLE_START');
// 忽略统计标记
$var_stat = $_GET['stat'] ?? null;
if (null !== $var_stat) {
    $expire = time() + 864000000;
    $setcookie = setcookie('stat', $var_stat, $expire, '/');
} else {
    $var_stat = Glob::conf('stat');
}
$disable_stat = $_COOKIE['stat'] ?? $var_stat;

$host_string = preg_replace("/\.|:/", '_', $_SERVER['HTTP_HOST'] ?? 'err');
$host_name = strtoupper($host_string);
$stat = [];

// 会话开始
$sname = Glob::conf('session.name');
$sid = $_GET['sid'] ?? null;
Stat::$unique = md5(json_encode($_SERVER));
Glob::$sid = $_COOKIE[$sname] ?? ($sid ?: Stat::$unique);
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
    $stat['cookie'] = Stat::cookie($redirect, "ENABLE_COOKIE_$host_name", null, Glob::$sid);
    PhpRedis::db();
    Glob::diff('STAT_COOKIE');
}

$debug = Glob::conf('debug');
$index = new Index($routeInfo, $httpMethod);
Glob::diff('EXAMPLE_INIT');
$result = $index->dispatch($debug);
Glob::diff('EXAMPLE_DISPATCH');
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
