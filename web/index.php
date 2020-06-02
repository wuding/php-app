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
$request_filename = __DIR__ . REQUEST_NAME;
if (preg_match('/^([a-z]?):\/(.*)/i', $request_urn, $matches)) {
    $request_filename = $request_urn;
}

// 定义与检测
$end_filename = BASE_DIR . '/src/app/' . trim($request_urn, '/') . '.php';
$directory = is_dir($request_filename) ? $request_filename : false;

// 判断
if (!$request_urn || preg_match('/^index$/i', $request_urn)) {
    include BASE_DIR . '/web/index.html';
} elseif ($directory) {
    include_once BASE_DIR . '/src/scandir.php';
} elseif (file_exists($request_filename)) {
    if ($_CONFIG['extensions'] && preg_match('/\.(?:'. $_CONFIG['extensions'] .')$/i', REQUEST_NAME, $matches)) {
        header('Content-type: '. mime_content_type($request_filename));
    }
    include_once $request_filename;
} elseif (!file_exists($end_filename)) {
    if ($rewrite_file) {
        include_once $rewrite_file;
    } else {
        include BASE_DIR . '/src/app.php';
    }
} else {
    include_once $end_filename;
}
