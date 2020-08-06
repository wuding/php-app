<?php

namespace PhpApp\Example;

use Stat;
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

// 忽略统计标记
$var_stat = $_GET['stat'] ?? null;
if (null !== $var_stat) {
    $expire = time() + 864000000;
    $setcookie = setcookie('stat', $var_stat, $expire, '/');
}
$disable_stat = $_COOKIE['stat'] ?? $var_stat;
$host_string = preg_replace("/\.|:/", '_', $_SERVER['HTTP_HOST'] ?? 'err');
$host_name = strtoupper($host_string);
$stat = [];
// 排除统计
$request_path = parse_url($uri, PHP_URL_PATH);
if (!preg_match("/^\/(stat|robot)(|\/.*)$/i", $request_path) && !$disable_stat) {
    $stat['server'] = Stat::server();
    $stat['url'] = Stat::record();
    // 禁用转向
    $redirect = true;
    if (preg_match("/^\/(robots|sitemap|play\/sitemap)(|\-\d+)\.(txt|xml|xml\.gz)$/i", $request_path)) {
        $redirect = false;
    }
    $stat['enable_cookie'] = Stat::cookie($redirect, "ENABLE_COOKIE_$host_name");
}

$debug = Glob::conf('debug');
$index = new Index($routeInfo, $httpMethod);
$result = $index->dispatch($debug);
if ($debug) {
    print_r(array($result, $stat, __FILE__, __LINE__));
}

if (null !== $debug) {
    $files = get_included_files();
    // 合并漏掉的
    extract(\Ext\Yac::hash('files', 'files_', 1));
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

/* vendor/composer/ClassLoader.php findFile()
extract(Yac::hash('files', 'files_', 1));
$arr = [];
if (false !== $cacheValue) {
    $arr = (array) $cacheValue;
}
$arr[$class] = realpath($file);
Yac::store($cacheKey, $arr, 30, 1);
*/
