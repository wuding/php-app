<?php

namespace phoenix\web;

use Pkg\Glob;
use MagicCube\Dispatcher;
use NewUI\Engine;

class Router
{
  // verb
  const BUILD = 20260206.173855;
  const EDITION = 0;
  const REVISION = 1;
  const VERSION = 26.0206;

  function __construct()
  {
    self::init();
    // include 'J:/http/php-app/vendor/wuding/php-func/src/Func.php';
  }

  static function autoload($filename = null)
  {
    $filename = $filename ?: ROOT .'/vendor/autoload.php';
    $require = require $filename;
    return $require;
  }

  static function init()
  {
    $constants = [
      'ROOT' => dirname(__DIR__),
    ];
    $psr4 = [
/*      'Dew\\' => ROOT .'/src/dew/',
      'Frost\\' => ROOT .'/src/frost/',
      'Snow\\' => ROOT .'/src/snow/',
      'Ice\\' => ROOT .'/src/ice/',
      'Func\\' => ROOT .'/src/func/',
      'Ext\\' => ROOT .'/src/ext/',
      'Pkg\\' => ROOT .'/src/pkg/',*/
    ];
    $includes = [];

    $var_array = include '../conf/develop.php';
    extract($var_array);

    $err = [];
    foreach ($constants as $name => $value) {
      if (defined($name)) {
        $err[$name] = constant($name);
        continue;
      }
      define($name, $value);
    }

    $autoload = self::autoload();
    $a = [];
    foreach ($psr4 as $key => $value) {
      $a[] = $autoload->addPsr4($key, $value);
    }

    $b = [];
    foreach ($includes as $key => $value) {
      $b[$key] = include $value;
    }
    return $err;
  }

  static function run()
  {
    global $template;
    // 导入配置
    Glob::$conf = include ROOT .'/conf/develop.php';

    $uri = self::uri();
    $debug = $_GET['debug'] ?? null;
    $vars = self::vars($uri);

    // 控制器、模板
    $nsTpl = "app\{m}{src}{extra}\controller\{c}";
    $ns = str_replace('{src}', $vars['srcDir'], $nsTpl);
    $extra = "\\theme\{t}";

    new Dispatcher($uri, Glob::class, $vars['prefix'], $vars['srcDir']);
    $obj = Dispatcher::dispatch($debug, $ns, $extra, $_GET ? null : $_SERVER['REQUEST_URI']);
    $template = new Engine();

    // 调试
    if ($debug) {
        // print_r(get_defined_vars());
        print_r(array(__FILE__, __LINE__));
        print_r(get_included_files());
    }
    return true;
  }

  static function vars($uri)
  {
    $prefix = null;
    $srcDir = '';

    $array = explode('/', $uri);
    list(, $module) = $array;
    $module_names = [
      // 'index',
    ];
    $module_folders = [
      'app',
      'api',
    ];

    $module = strtolower($module) ?: 'index';
    if ($module && $module_names && !in_array($module, $module_names)) {
        $prefix = "/index/entry/index";
    }

    $haystack = $module_folders ?: array('note', 'git');
    if (in_array($module, $haystack)) {
        $srcDir = '\src';
    }

    return [
      'prefix' => $prefix,
      'srcDir' => $srcDir,
    ];
  }

  static function uri()
  {
    $request_uri = $_SERVER['REQUEST_URI'];
    $request_uri = preg_replace("/^\/+/", '/', $request_uri);
    $path = parse_url($request_uri, PHP_URL_PATH);
    $path = urldecode($path);
    $var_array = pathinfo($path);
    extract($var_array);

    $dirname = '\\' === $dirname ? '' : $dirname;
    $uri = $dirname ."/". $filename;
    return $uri = preg_replace("/^\/\//", '/', $uri);
  }
}

$Router = new Router();
return Router::run();
