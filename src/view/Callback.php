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
      # return 'replace all the apples with oranges';
      return [__FILE__, $buffer];
    }
}
