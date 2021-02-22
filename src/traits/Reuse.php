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
}
