<?php

define('ROOT', dirname(__DIR__));

$autoload = require ROOT ."/vendor/autoload.php";

use function php\func\{server, get, cookie, globals};
use MagicCube\Dispatcher;
use NewUI\Engine;
use Pkg\{Glob, X\GeoIP};
use Ext\X\Redis as PhpRedis;
use Ext\GetText;
use api\pinduoduo\src\Ddk;

$array = array(
    'type' => 'pdd.ddk.goods.search',
    'data_type' => 'JSON',
    'client_id' => '0dc37cc2bd2f446da63fdaa24c2b71c7',
    'timestamp' => '1631359911',
);
$array = array(
    'type' => 'pdd.ddk.goods.promotion.url.generate',
    'data_type' => 'JSON',
    'client_id' => '0dc37cc2bd2f446da63fdaa24c2b71c7',
    'timestamp' => '1631359911',
    'generate_authority_url' => 'true',
    'goods_sign_list' => '["Y9P2jJdeLgpGX4PxwfDZjgqWZN5OCAwg_JQ1kukE6nO"]',
    'p_id' => '1916625_209040306',
);
$clientSecret = "139224afbdab39a6be66f3523d3cbf979157425c";
$str = Ddk::generateSign($array, $clientSecret);
$array['sign'] = $str;
$url = Ddk::generateUrl($array);
var_dump($url);
