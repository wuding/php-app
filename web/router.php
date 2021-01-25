<?php

define('ROOT', dirname(__DIR__));

$autoload = require ROOT ."/vendor/autoload.php";

use MagicCube\Dispatcher;
use NewUI\Engine;
use Pkg\Glob;
use Ext\X\Redis as PhpRedis;

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
    // 配置
    $server = Glob::conf('merge.server');
    $country_uids = Glob::conf('geo.country_uids');
    $redis_conf = Glob::cnf('mem.alias.connect', 'redis') ?? array();

    // 自定义变量
    $_SERVER = array_merge($_SERVER, $server);
    $remote_addr = $_SERVER['REMOTE_ADDR'] ?? null;

    // 默认 UID
    $uid = get_uid_by_addr(1, $remote_addr, $country_uids);
    define('DEFAULT_UID', $uid);

    // 内存缓存
    Glob::$obj['Redis'] = new PhpRedis($redis_conf);

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

// 通过客户端 IP 地址所属国家获取配置的默认用户 ID
function get_uid_by_addr($uid = null, $remote_addr = null, $country_uids = array())
{
    $country = $remote_addr ? geoip_country_code_by_name($remote_addr) : '';
    if (is_string($country)) {
        if (isset($country_uids[$country])) {
            $uid = $country_uids[$country];
        } else {
            var_dump($country);
            print_r([__LINE__, __FILE__]);
        }
    } elseif (false !== $country) {
        var_dump($country);
        print_r([__LINE__, __FILE__]);
    }
    return $uid;
}

return router();
