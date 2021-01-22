<?php

date_default_timezone_set('PRC');

return array(
    // 数据库连接配置
    'db' => array(
        'alias' => array(
            'connect' => 'db.server.master'
        ),
        'server' => array(
            'master' => array(
                'username' => '',
                'password' => '',
                'port' => 3306,
            ),
            'slave' => array(
                'username' => '',
                'password' => '',
                'port' => 3307,
            ),
        ),
    ),
    'database' => null, // 简单写法，替代 db.server.master
    // 内存缓存配置
    'mem' => array(
        'alias' => array(
            'connect' => 'mem.server.master'
        ),
        'server' => array(
            'master' => array(
                'host' => '127.0.0.1',
                'port' => 6379,
                'timeout' => 0,
                'reserved' => null,
                'retry_interval' => 0,
                'read_timeout' => 0,
                'option' => array('auth' => ''),
                'method' => 'pconnect',
            ),
        ),
    ),
    'redis' => null, // 简单写法，替代 mem.server.master
    // 视图变量配置
    'view' => array(
        'cdn_prefix' => '',
        'favicon_default' => '/img/favicon/default.png',
    ),
    // 合并覆盖超全局变量
    'merge' => array(
        'server' => array(
            #'REMOTE_ADDR' => '',
        ),
    ),
    // 地理位置
    'geo' => array(
        'country_uids' => array(
            '' => 0,
            'CN' => 0,
            'US' => 0,
        ),
    ),
);
