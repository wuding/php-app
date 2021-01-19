<?php

date_default_timezone_set('PRC');

return array(
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
    'view' => array(
        'cdn_prefix' => '',
    ),
);
