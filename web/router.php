<?php

define('ROOT', dirname(__DIR__));

$autoload = require ROOT ."/vendor/autoload.php";

use MagicCube\Dispatcher;
use NewUI\Engine;
use Pkg\Glob;

#header("content-type: text/plain");
/*
$token = $_GET['token'] ?? null;
$sid = $_COOKIE['SID'] ?? null;

$token = isset($_GET['token']) ? $_GET['token'] : null;
$sid = isset($_COOKIE['SID']) ? $_COOKIE['SID'] : null;
if ($token !== $sid) {
    #return true;
}
$test = dirname(__FILE__);*/
/*ksort($_SERVER);
print_r($_SERVER);strstr($_SERVER['REQUEST_URI'], '?', true)
*/

function has2($arr, $key, $value = null) {
    if (isset($arr[$key]) && $arr[$key]) {
        return $arr[$key];
    }
    return $value;
}

session_start();

function router() {
    global $template;
    // 参数、变量
    $src = $_GET['src'] ?? null;
    $debug = $_GET['debug'] ?? null;
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = urldecode($path);
    $file = __DIR__ . $path;
    $is_file = is_file($file);

    // 检测、查看源码
    if ($is_file && file_exists($file)) {
        if ($src) {
            readfile($file);
            return true;
        }
        return false;
    }

    // 标准化请求地址
    $var_array = pathinfo($path);
    extract($var_array);
    $dirname = '\\' === $dirname ? '' : $dirname;
    $uri = $dirname ."/". $filename;

    // 准备
    Glob::$conf = include ROOT .'/conf/develop.php';

    // 控制器、模板
    new Dispatcher($uri);
    $obj = Dispatcher::dispatch($debug);
    $template = new Engine();

    // 调试
    if ($debug) {
        print_r(get_defined_vars());
        print_r(array(__FILE__, __LINE__));
        print_r(get_included_files());
    }
    return true;
}
return router();
