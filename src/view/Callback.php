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
        return Zlib::putContents($filename, $buffer);
    }

    // 读取，另存为 .zip 7-Zip 打开才正常
    public static function gzip($buffer)
    {
        $filename = Glob::conf('outputCallback.gz');
        $str = File::getContents(realpath($filename));
        return $str;
    }
}
