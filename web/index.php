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
defined('REQUEST_NAME') ? : define('REQUEST_NAME', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
defined('BASE_DIR') ? : define('BASE_DIR', dirname(__DIR__));
$_CONFIG = include BASE_DIR . '/app/config.php';
$rewrite_file = $_CONFIG['rewrite_file'] ?? null;

$sorting_order = isset($_GET['sort']) ? $_GET['sort'] : null;
$request_urn = preg_replace('/^\/|\.(html|htm|php)$/i', '', REQUEST_NAME);
$request_filename = __DIR__ . REQUEST_NAME;
$end_filename = BASE_DIR . '/app/' . trim($request_urn, '/') . '.php';
$directory = is_dir($request_filename) ? $request_filename : false;

if (!$request_urn || preg_match('/^index$/i', $request_urn)) {
    include BASE_DIR . '/web/index.html';
} elseif ($directory) {
    include BASE_DIR . '/src/scandir.php';
} elseif (file_exists($request_filename)) {
    include $request_filename;
} elseif (!file_exists($end_filename)) {
    # print_r(get_defined_vars());exit;
    if ($rewrite_file) {
        include $rewrite_file;
    } else {
        include BASE_DIR . '/app/template/404.html';
    }
} else {
    include $end_filename;
}

