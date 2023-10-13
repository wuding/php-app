<?php

error_reporting(E_ALL);

define('ROOT', dirname(__DIR__));

$autoload = require ROOT ."/vendor/autoload.php";

use function php\func\{server, get, cookie, globals};
use MagicCube\Dispatcher;
use NewUI\Engine;
use Pkg\{Glob, X\GeoIP};
use Ext\X\Redis as PhpRedis;
use Ext\GetText;
use Ext\Err;
use Ext\Sess;

class Router
{
    const VERSION = '23.9.2';
    const REVISION = 26;
    const EDITION = array(
        11,
        11,
        8,
        1,
        1,
    );



    /*
    +---------------------------------------------+
    + CORE
    +---------------------------------------------+
    */


    // initial
    public function __construct()
    {
        // 9

        $args = func_get_args();
        // extract($args[0]);

        $Sess = new Sess;
        $sess_start = Sess::start($args[0]['conf']['ext']['session']);

        unset($args);
/*
        var_dump($expression = [__FILE__, __LINE__,
            'vars' => get_defined_vars(),
        ]);
*/

    }


    public function startUp()
    {

    }



    /*
    +---------------------------------------------+
    + COMPILE
    +---------------------------------------------+
    */


    public function complieTime()
    {

    }


    public function parse()
    {

    }



    /*
    +---------------------------------------------+
    + E
    +---------------------------------------------+
    */


    public function runTime()
    {

    }





    // fatal
    public function error()
    {

    }


    // no-fatal
    public function warning()
    {

    }


    public function strict()
    {

    }


    public function all()
    {

    }



    /*
    +---------------------------------------------+
    + USER
    +---------------------------------------------+
    */


    // trigger_error()
    public function userGenerated()
    {

    }


    public function notice()
    {

    }


    public function deprecated()
    {

    }



    /*
    +---------------------------------------------+
    + RECOVERABLE
    +---------------------------------------------+
    */


    // set_error_handler()
    public function catchable()
    {

    }

}

$param_arr = array(
    'conf' => require ROOT .'/conf/develop.php',
);

$Router = new Router($param_arr);

// session_start();

function router($check_file = null) {
    global $template;
    // 导入配置
    Glob::$conf = include ROOT .'/conf/develop.php';



    // 模拟超全局变量
    $server = Glob::conf('merge.server');
    $_SERVER = array_merge($_SERVER, $server ?? array());

    // 参数、变量
    $src = get('src');
    $debug = get('debug');
    $request_uri = server('REQUEST_URI');
    $request_uri = preg_replace("/^\/+/", '/', $request_uri);
    $path = parse_url($request_uri, PHP_URL_PATH);
    $path = urldecode($path);
    $file = __DIR__ . $path;
    $is_file = $check_file ? is_file($file) : null;

    // 检测、查看源码
    if ($is_file && file_exists($file)) {
        if ($src) {
            readfile($file);
            return true;
        }
        return false;
    }

    // throw Exception
    Err::$config['env'] = 'development';
    Err::setExceptionHandler();

    $GLOBALS['_LANG'] = array();

    // 标准化请求地址
    $var_array = pathinfo($path);
    extract($var_array);
    $dirname = '\\' === $dirname ? '' : $dirname;
    $uri = $dirname ."/". $filename;

    // 语言
    $language = Glob::conf('locale.default_language');
    $languages = Glob::conf('locale.available_languages');
    $langs = array_keys($languages ?? array());
    $lng = Glob::lang($language);
    $lang = cookie('lang') ?: $lng;
    $lang = variant($lang);
    if (!in_array($lang, $langs)) {
        $lang = $language;
    }
    $country = ($languages[$lang] ?? null) ?: 'Globe';
    // 本地化
    $domain = Glob::conf('locale.domain') ?: $lang;
    $directory = Glob::conf('locale.directory');
    $func = Glob::conf('locale.func');
    if ('gettext' === $func) {
        // 故意错误目录，清空缓存
        $bind = bindtextdomain($domain, "./$domain/". time());
        $GetText = new GetText(LC_ALL, $lang, $directory, $domain);
    } elseif ('\php\func\lang' === $func) {
        $LANG = Glob::lng($lang, $directory, $domain, $langs, false);
    }
    // 配置
    $GLOBALS['_CONF'] = array('lang' => $lang, 'country' => $country);

    // 配置
    $country_uids = Glob::conf('geo.country_uids');
    $redis_conf = Glob::cnf('mem.alias.connect', 'redis') ?? array();
    $custom_directory = Glob::conf('ext.geoip.custom_directory');
    $module_names = Glob::conf('module.*');
    $module_folders = Glob::conf('module./', array());

    // IP
    $remote_addr = server('REMOTE_ADDR');

    // 注册容器
    Glob::set('GeoIP', new GeoIP($remote_addr, $custom_directory));

    // 默认 UID
    $uid = get_uid_by_addr(1, $remote_addr, $country_uids);
    define('DEFAULT_UID', $uid);

    // 内存缓存
    // $mem = Glob::set('Mem', new PhpRedis($redis_conf));
    $mem = Glob::set('Mem', new PhpRedis($redis_conf));

    // 控制器、模板
    $array = explode('/', $uri);
    list(, $module) = $array;
    $module = strtolower($module) ?: 'index';
    $prefix = null;
    if ($module && $module_names && !in_array($module, $module_names)) {
        $prefix = "/index/entry/index";
    }

    $srcDir = '';
    $haystack = $module_folders ?: array('note', 'git');
    if (in_array($module, $haystack)) {
        $srcDir = '\src';
    }

    $nsTpl = "app\{m}{src}{extra}\controller\{c}";
    $ns = str_replace('{src}', $srcDir, $nsTpl);
    $extra = "\\theme\{t}";

    new Dispatcher($uri, Glob::class, $prefix);
    $obj = Dispatcher::dispatch($debug, $ns, $extra, $_GET ? null : $_SERVER['REQUEST_URI']);
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
function get_uid_by_addr($uid = null, $remote_addr = null, $country_uids = array(), $geo_ip = 'GeoIP')
{
    $GeoIP = is_string($geo_ip) ? Glob::get($geo_ip) : $geo_ip;
    $country = $remote_addr ? $GeoIP->countryCode($remote_addr) : '';
    if (is_string($country)) {
        if (isset($country_uids[$country])) {
            $uid = $country_uids[$country];
        } else { // 未设置国家
            #var_dump($country);
            #print_r([__LINE__, __FILE__]);
        }
    } elseif (false !== $country) {
        var_dump($country);
        print_r([__LINE__, __FILE__]);
    }
    return $uid;
}

// 语言变体
function variant($language)
{
    //=s
    $lang = strtolower($language);
    if ('zh' === $lang) {
        return $lang;
    }

    //=f
    $arr = array();
    $variable = array(
        'main',
        'variant',
    );

    //=z
    $LNG = preg_split("/\W+/", $lang);

    //=sh
    foreach ($variable as $key => $value) {
        $arr[$value] = globals($key, null, $LNG);
    }
    extract($arr);

    //=l
    if ('zh' === $main) {
        if (!$variant) {
            return $lang;
        }
        // 繁体
        if (in_array($variant, array('hant', 'tw', 'hk', 'mo'))) {
            return $lang = "zh-hant";
        } elseif (in_array($variant, array('hans', 'cn', 'sg', 'my'))) { // 简体
            return $lang = "zh";
        } else { // 其他
            return $main;
        }
    }

    //=j

    //=g
    return $lang;
}

return router('cli-server' === php_sapi_name());
