<?php
// router.php
# echo php_sapi_name() . '_' . PHP_SAPI;

/**
增加了对请求的预处理，比如文件扩展名
检测文件是否存在，自定义错误页面
包含点 . 的直接查找输出文件，没有 PATH_INFO，SCRIPT_NAME、SCRIPT_FILENAME、PHP_SELF 会有变化
否则会有 PATH_INFO，用入口文件处理
**/
define('REQUEST_NAME', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
define('BASE_DIR', dirname(__DIR__));

$request_filename = __DIR__ . REQUEST_NAME;

if (preg_match('/\.(?:png|jpg|jpeg|gif|ico)$/i', REQUEST_NAME)) {
	if (file_exists($request_filename)) {
		return false;    // 直接返回请求的文件
	}
    include BASE_DIR . '/app/template/404.html';

} else { 
    # echo "<p>Welcome to PHP</p>";
    include 'index.php';
}
