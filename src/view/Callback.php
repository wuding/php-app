<?php
namespace view;

use Ext\File;
use Ext\Zlib;
use model\Glob;

/**
 * 模板引擎输出回调类
 */
class Callback
{
    public static $put = null;
    public static $gz = false;

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
        $result = self::$gz ? self::$put : false;
        return $result;
    }

    // 读取，另存为 .zip 7-Zip 打开才正常
    public static function gzip($buffer)
    {
        $filename = Glob::conf('outputCallback.gz');
        $str = File::getContents(realpath($filename));
        return $str;
    }

    public static function hook()
    {
        $args = func_get_args();
        $gz = self::gz($args[0]);
        $gzip = self::gzip($args[1]);
        $render = \NewUI\Template::$render_result;
        File::putContents('hook.txt', print_r(get_defined_vars(), true));
    }
}
