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

    public static function duration($str)
    {
        return $str = date('i:s', $str / 1000);
    }

    public static function alias($str)
    {
        $arr = (array) json_decode($str);
        $str = implode(', ', $arr);
        return $str ? " &nbsp;$str" : null;
    }

    public static function mv($mv)
    {
        return $str = $mv ? "<a href=\"https://music.163.com/mv?id=$mv\">▶</a>" : null;
    }

    public static function artists($artists)
    {
        $arr = explode(',', $artists);
        $pieces = [];
        foreach ($arr as $key => $value) {
            if ($value) {
                $row = self::$artists[$value] ?? null;
                if ($row) {
                    $pieces[] = "<a href=\"/music/artist/$value/site/1\">$row->name</a>";
                }
            }
        }
        return implode(' / ', $pieces);
    }

    public static function home($home)
    {
        return $str = $home ? "<a href=\"https://music.163.com/user/home?id=$home\">$home</a>" : null;
    }

    public static function publishTime($publishTime)
    {
        return $str = $publishTime ? date('Y-m-d H:i:s', $publishTime / 1000) : null;
    }

    public static function pic($pic)
    {
        return $str = $pic ? "<img style=\"width:24px\" src=\"$pic?param=24y24\">" : null;
    }
}
