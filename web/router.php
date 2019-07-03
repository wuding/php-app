<?php
// router.php
# echo php_sapi_name() . '_' . PHP_SAPI;

// 选项设置
$ini_array = parse_ini_file(".user.ini");
$ini_result = array();
$ini_reset = array();
foreach ($ini_array as $key => $value) {
    $oldvalue = ini_set($key, (string) $value);
    if (false === $oldvalue) {
        $ini_result[$key] = $value;
    } elseif ($oldvalue != $value) {
        $ini_reset[$key] = array($value, $oldvalue);
    }
}
if ($ini_result) {
    print_r([__FILE__, __LINE__, $ini_result]);
}
if ($ini_reset) {
    print_r([__FILE__, __LINE__, $ini_reset]);
}

# set_time_limit(1);

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
