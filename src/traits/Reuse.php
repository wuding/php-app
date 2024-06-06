<?php

namespace src\traits;

trait Reuse
{
    // 翻译语言
    public static function lang($lang = null, $func = null)
    {
        foreach ($lang as $key => $value) {
            if (is_numeric($key)) {
                $val = preg_replace("/\W+/", '_', $value);
                $val = strtolower($val);
                unset($lang[$key]);
                $key = "_$val";
            }
            $lang[$key] = $func ? $func($value) : $value;
        }
        return $lang;
    }

    /*
    address
    */

    // module
    // config.php
    public static function getModuleConfigFilename($class = '', $file = 'config.php')
    {
        $root = constant('ROOT');
        $pathname = self::getAppPathname($class);
        $arr = array($root, $pathname, $file);
        // $filename = $pathname .'/'. $file;
        $filename = implode('/', $arr);
        return $filename;
        var_dump([__FILE__, __LINE__,  get_defined_vars()]);exit;
    }

    public static function getAppPathname($class = '', $patter = 'src|controller')
    {
        $arr = explode('\\', $class);
        $pattern = "/^(". $patter .")$/";
        // $pattern = "/(src|controller)/";

        $dirs = array();
        foreach ($arr as $key => $value) {
            // if ('src' === $value) {
            if (preg_match($pattern, $value)) {
                break;
            }
            $dirs[] = $value;
        }

        $str = implode('/', $dirs);
        return $str;
        var_dump([__FILE__, __LINE__, $arr, $dirs, $str]);exit;
    }

    /*
    content
    */
}
