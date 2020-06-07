<?php
// index.php
# echo 'It works!';

/**
全静态服务器只保留 index.html
动静结合要有 index.php
全动态使用路由 router.php

忽略常用网页扩展名
默认索引文件
目录扫描
文件是否存在
检测模块是否存在，自定义错误页面
预定义最终执行文件
**/

// 常量
defined('REQUEST_NAME') ? : define('REQUEST_NAME', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
defined('BASE_DIR') ? : define('BASE_DIR', dirname(__DIR__));

// 配置
$_CONFIG = include BASE_DIR . '/app/config.php';
$rewrite_file = $_CONFIG['rewrite_file'] ?? null;
date_default_timezone_set($_CONFIG['timezone'] ?? 'UTC');
set_time_limit($_CONFIG['time_limit'] ?? 1);

// 请求
$sorting_order = isset($_GET['sort']) ? $_GET['sort'] : null;
$request_urn = preg_replace('/^\/|\.(html|htm|php)$/i', '', REQUEST_NAME);
$request_filename = $_CONFIG['file_exists_dir'] . REQUEST_NAME;
$drv_matches = array();
if (preg_match('/^([a-z]?):\/(.*)/i', $request_urn, $drv_matches)) {
    $request_filename = $request_urn;
}
$request_filename = rawurldecode($request_filename);
$request_filename = mb_convert_encoding($request_filename, 'GBK');

// 定义与检测
$end_filename = BASE_DIR . '/src/app/' . trim($request_urn, '/') . '.php';
$directory = is_dir($request_filename) ? $request_filename : false;

// 判断
$result_type = 0;
$arr = array(
    $end_filename,
    BASE_DIR . '/web/index.html',
    BASE_DIR . '/src/scandir.php',
    $request_filename,
    $request_filename,
    BASE_DIR . '/src/app.php',
    $rewrite_file,
);

if (!$request_urn || preg_match('/^index$/i', $request_urn)) {
    $result_type = 1;
} elseif ($directory) {
    $result_type = 2;
} elseif (file_exists($request_filename)) {
    $result_type = 3;
    if ($_CONFIG['extensions'] && preg_match('/\.(?:'. $_CONFIG['extensions'] .')$/i', REQUEST_NAME, $matches)) {
        header('Content-type: '. mime_content_type($request_filename));
        $result_type = 4;
    }
} elseif (!file_exists($end_filename)) {
    $result_type = 5;
    if ($rewrite_file) {
        $result_type = 6;
    }
} else {
    require BASE_DIR . '/vendor/autoload.php';
}

include_once $arr[$result_type];
