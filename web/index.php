<?php

namespace phoenix\web;

use Pkg\Glob;
use MagicCube\Dispatcher;
use NewUI\Engine;
use Ext\X\Redis as PhpRedis;

// ocr
// use thiagoalessio\TesseractOCR\TesseractOCR;

class Router
{
  // verb
  const BUILD = 20260206.173855;
  const EDITION = 3.30;
  const REVISION = 3;
  const VERSION = 26.0721;

  function __construct()
  {
    self::init();
  }

  static function autoload($filename = null)
  {
    $filename = $filename ?: ROOT .'/vendor/autoload.php';
    $require = require $filename;
    return $require;
  }

  static function init()
  {
    $var_array = include '../conf/develop.php';
    $constants = $var_array['constants'] ?? [];
    $psr4 = $var_array['psr4'] ?? [];
    $includes = $var_array['includes'] ?? [];

    $err = $a = $b = [];
    foreach ($constants as $name => $value) {
      if (defined($name)) {
        $err[$name] = constant($name);
        continue;
      }
      define($name, $value);
    }

    $autoload = self::autoload();
    foreach ($psr4 as $key => $value) {
      $a[$key] = $autoload->addPsr4($key, $value);
    }
    foreach ($includes as $key => $value) {
      $b[$key] = include $value;
    }

    // 导入配置
    // Glob::$conf = $var_array;
    new Glob($var_array);
    $timezoneId = Glob::conf('ini.date.timezone');
    $tz = $timezoneId ? date_default_timezone_set($timezoneId) : 'nul';
    // $tzs = date_default_timezone_get();
    // print_r(get_defined_vars());
    return $err;
  }

  static function run()
  {
    global $template;
    $redis_conf = Glob::cnf('mem.alias.connect', 'redis') ?? array();
    $mem = Glob::set('Mem', new PhpRedis($redis_conf));
    $needle = Glob::conf('debug.run', true);

    $uri = self::uri();
    $debug = $_GET['debug'] ?? null;
    $vars = self::vars($uri);
    $haystack = explode(',', $debug);

    // 控制器、模板
    $nsTpl = "app\{m}{src}{extra}\controller\{c}";
    $ns = str_replace('{src}', $vars['srcDir'], $nsTpl);
    $extra = "\\theme\{t}";

    $template = new Engine();
    new Dispatcher($uri, Glob::class, $vars['prefix'], $vars['srcDir']);
    $obj = Dispatcher::dispatch($debug, $ns, $extra, $_GET ? null : $_SERVER['REQUEST_URI']);

    // 调试
    if (in_array($needle, $haystack, true)) {
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
    // var_dump([$array, $uri]);
    list(, $module) = $array;
    $module_names = [
      // 'index',
    ];
    $module_folders = Glob::conf('modules');

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
    $uri = preg_replace("/^\/\//", '/', $uri);
    $uri = preg_replace("/^\/index/", '', $uri);
    $pattern = "#(search|watch|play)#";
    if (preg_match($pattern, $uri, $matches)) {
        $uri = "/index$uri";
    }
    // $uri = rtrim($uri, '/');
    return $uri;
  }

  static function ocr()
  {
    $text = (new TesseractOCR('path/to/image.png'))
    ->lang('eng') // language, you can also use other traineddata if installed
    ->run();

echo $text;
  }
}

// ksort($_SERVER);
// print_r($GLOBALS);
$Router = new Router();
return Router::run();
// return Router::ocr();
