<?php
namespace view;

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
}
