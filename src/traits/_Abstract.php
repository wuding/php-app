<?php

namespace src\traits;

use Ext\File;
use Ext\Zlib;

trait _Abstract
{
    public static function _outputJson($code = null, $msg = null, $data = null)
    {
        $arr = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
        return json_encode($arr);
    }
}
