<?php

namespace model;

use Ext\X\PhpRedis;

class Mem
{
    public function __construct()
    {

    }

    public function __call($name, $arguments)
    {
        print_r([get_defined_vars(), __FILE__, __LINE__]);
    }

    public static function __callStatic($name, $arguments)
    {
        print_r([get_defined_vars(), __FILE__, __LINE__]);
    }

    // 将 SQL 等散列值作为键名，支持 JSON 编码
    public static function hash($str = null, $prefix = null, $json = null)
    {
        $md5 = md5($str);
        $cacheKey = $prefix . $md5;
        $cacheValue = static::get($cacheKey);
        // 改变类型
        if (is_string($cacheValue)) {
            // JSON 格式的数组或对象
            if (preg_match("/^\[{\"(.*)}\]$/", $cacheValue, $matches) || preg_match("/^{\"(.*)\"}$/", $cacheValue, $matches)) {
                $json = true;
            } elseif (in_array($cacheValue, array('[]', 'false'))) {
                $json = true;
            } elseif (!is_numeric($cacheValue)) {
                var_dump([$cacheKey, $cacheValue, __FILE__, __LINE__]);
                exit;
            }
        } elseif(false !== $cacheValue) {
            var_dump([$cacheKey, $cacheValue, __FILE__, __LINE__]);
            exit;
        }
        // JSON 编码
        if ($json && false !== $cacheValue) {
            $cacheValue = json_decode($cacheValue);
        }
        return ['cacheKey' => $cacheKey, 'cacheValue' => $cacheValue];
    }

    public static function get($key = null)
    {
        return PhpRedis::get($key);
    }

    // 存储或删除
    public static function store($key = null, $value = null, $ttl = null, $json = null)
    {
        // 存活时间
        if (!$ttl) {
            return -1;
        }
        if (0 > $ttl) {
            return PhpRedis::del($key);
        }
        // JSON 格式化数组或对象
        if (is_object($value) || is_array($value) || is_bool($value)) {
            $json = true;
        } elseif (!is_string($value)) {
            var_dump([$key, $value, __FILE__, __LINE__]);
            exit;
        }
        if ($json) {
            $value = json_encode($value);
        }
        $result = PhpRedis::set($key, $value, is_numeric($ttl) ? $ttl : 0);
        if (!$result) {
            var_dump($result);
            print_r([get_defined_vars(), __FILE__, __LINE__]);
            exit;
        }
        return $result;
    }
}
