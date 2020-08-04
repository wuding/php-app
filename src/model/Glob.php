<?php
namespace model;

class Glob
{
    public static $conf = [];
    public static $supported_ext = null;

    // 给配置项设值
    public static function set($item, $value = null)
    {
        $exp = explode('.', $item);
        $str = '';
        foreach ($exp as $v) {
            $str .= "['$v']";
        }
        eval("self::\$conf$str = '$value';");
        return self::$conf;
    }

    // 获取配置项的值
    public static function conf($item, $value = null, $arr = null)
    {
        $pos = strpos($item, '.');
        $arr = $arr ?: self::$conf;
        if (false !== $pos) {
            $remain = substr($item, $pos + 1);
            $itm = substr($item, 0, $pos);
            $vars = $arr[$itm] ?? [];
            return $var = self::conf($remain, $value, $vars);
        }
        return $var = $arr[$item] ?? $value;
    }

    // 第一项作为键名再次获取
    public static function cnf($item, $value = null, $val = null)
    {
        $var = self::conf($item, $value);
        return self::conf($var, $val);
    }

    // 获取合并后的扩展名支持
    public static function supportedExt()
    {
        if (null !== self::$supported_ext) {
            return self::$supported_ext;
        }

        $variable = ['supported_ext', 'videojs_ext', 'dplayer_ext'];
        $array = [];
        foreach ($variable as $value) {
            $array = array_merge($array, self::$conf[$value]);
        }
        return self::$supported_ext = array_unique($array);
    }
}
