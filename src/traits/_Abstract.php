<?php
namespace traits;

trait _Abstract
{
    public function _errorReport()
    {
        print_r(func_get_args());
    }

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
