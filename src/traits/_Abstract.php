<?php

namespace src\traits;

use Ext\File;
use Ext\Zlib;

trait _Abstract
{
    public static function _outputJson($code = null, $msg = null, $data = null, $var_array = null)
    {
        $options = 0;
        if (is_array($var_array)) {
            extract($var_array);
        }
        $arr = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
        return json_encode($arr, $options);
    }
}
