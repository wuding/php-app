<?php

namespace model;

use Ext\Math;

class Glob
{
    public static $conf = [];
    public static $supported_ext = null;
    public static $timeNode = ['sql' => []];
    public static $lastTime = null;
    public static $sid = null;
    public static $diffNode = [];
    public static $sql = [];

    // 给配置项设值
    public static function set($item, $value = null)
    {
        $exp = explode('.', $item);
        $str = '';
        foreach ($exp as $v) {
            $str .= "['$v']";
        }
        eval("self::\$conf$str = \$value;");
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

    // 运行时间标记
    public static function time($key = null, $time = null)
    {

        $time = null === $time ? microtime(true) : $time;
        if (null === $key) {
            self::$timeNode[] = $time;
        } else {
            self::$timeNode[$key] = $time;
        }

    }

    // 运行时间差
    public static function diff($key = null)
    {

        $lt = self::$lastTime ?: $_SERVER['REQUEST_TIME_FLOAT'];
        self::$lastTime = $m = microtime(true);
        $diff = $m - $lt;
        $diff = Math::floors($diff * 1000, 2);
        self::time($key, $diff);

    }

    // 只计算设定节点的时间差
    public static function dif($key)
    {
        if (in_array($key, self::$diffNode)) {
            self::diff($key);
        }
    }

    public static function sql($str = null)
    {
        #self::$sql[] = $str;
        #print_r(self::$sql);
        self::$timeNode['sql'][] = $str;
    }
}
