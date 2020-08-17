<?php

namespace view;

use Ext\File;
use Ext\Zlib;
use Ext\X\PhpRedis;
use model\Glob;

/**
 * 模板引擎输出回调类
 */
class Callback
{

    use \MagicCube\Traits\_Abstract;

    public static $put = null;
    public static $gz = false;
    public static $ext = null;

    public function __construct($argument)
    {
        # code...
    }

    public static function output($buffer)
    {
      // 不能返回数组或对象，也不能直接输出
      return print_r(array('file' => __FILE__, 'buffer' => $buffer), true);
    }

    // 写入
    public static function gz($buffer)
    {
        $filename = Glob::conf('outputCallback.gz');
        self::$put = Zlib::putContents($filename, $buffer);
        \NewUI\Template::$render_result = $buffer;
        $hook = \MagicCube\Controller::$hook;
        // 不可以回调用户函数，死循环
        #call_user_func_array($hook, ['_' => $buffer, 'var' => 'vars']);
        $result = self::$gz ? self::$put : Zlib::encode($buffer);//false
        return $result;
    }

    // 读取，另存为 .zip 7-Zip 打开才正常
    public static function gzip($buffer)
    {
        $filename = Glob::conf('outputCallback.gz');
        $decode = 'xml' === self::$ext ? true : false;
        $str = Zlib::getContents(realpath($filename), null, $decode);
        return $str;
    }

    // 直接返回
    public static function test($buffer)
    {
        return $buffer;
    }

    public static function hook()
    {
        $args = func_get_args();
        extract($args[0]);
        unset($args);
        #$render = \NewUI\Template::$render_result;
        #File::putContents('hook.txt', $render);
        $cacheKey = Glob::conf('module.video.index.index.cacheKey');
        $ttl = Glob::conf('module.video.index.index.ttl');
        $cacheValue = PhpRedis::get($cacheKey) ?: null;
        $type = gettype($cacheValue);
        $render_type = gettype($render);
        if ('string' === $type && $cacheValue) {
            print_r(['cache type string', "render type $render_type", __FILE__, __LINE__]);
            #echo $cacheValue;
        } elseif ($render) {
            $set = PhpRedis::set($cacheKey, $render, $ttl ? (int) $ttl : 10);
            $cacheValue = str_replace(' cached</php>', '</php>', $render);
            echo self::_gzip($cacheValue, Glob::conf('gzip'));
        } else {
            print_r(["render null, type $render_type", __FILE__, __LINE__]);
            var_dump($render);
        }
    }

    public static function tpl_callback($buffer, $what = null)
    {
        return print_r([$buffer, $what], true);
    }
}
