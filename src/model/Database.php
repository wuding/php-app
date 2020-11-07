<?php

namespace model;

class Database
{
    // 配置
    public static $config = [
        'host' => '127.0.0.1',
        'port' => 3306,
        'dbname' => 'mysql',
        'username' => 'test',
        'password' => 'test',
    ];

    // 运行时
    public static $hand = null;

    public static function __callStatic($name, $arguments = [])
    {
        return call_user_func_array(array(self::hand(), $name), $arguments);
    }

    public static function hand()
    {
        if (null !== self::$hand) {
            return self::$hand;
        }
        $config = self::config();
        $dsn = self::dsn($config);
        extract($config);
        return self::$hand = new \Ext\PDO($dsn, $username, $password);
    }

    public static function config()
    {
        $db_config = Glob::cnf('database_play', 'database');
        $db_config['dbname'] = $db_config['db_name'];
        $variable = static::$config;
        $arr = [];
        foreach ($variable as $key => $value) {
            $val  = $db_config[$key] ?? null;
            $arr[$key] = $val ?: $value;
        }
        return $arr;
    }

    public static function dsn($variable = [], $prefix = 'mysql', $allow = ['host', 'port', 'dbname'])
    {
        $pieces = [];
        foreach ($variable as $key => $value) {
            if ($allow && !in_array($key, $allow)) {
                continue 1;
            }

            $fragment = "";
            if (!is_numeric($key) && $key) {
                $fragment .= "$key=";
            }
            $fragment .= $value;
            $pieces[] = $fragment;
        }

        $str = implode(';', $pieces);
        $dsn = "$prefix:$str";
        return $dsn;
    }

    public static function from()
    {
        return $db_table = "`". static::$db_name ."`.`". static::$table_name ."`";
    }
}
