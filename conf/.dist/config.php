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
                'username' => '<USER>',
                'password' => '<PASS>',
                'port' => 3306,
                'host' => 'localhost'
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
                'option' => array('auth' => '<PASSWORD>'),
                'method' => 'pconnect',
            ),
        ),
    ),
    'redis' => null, // 简单写法，替代 mem.server.master
    // 视图变量配置
    'view' => array(
        'cdn_prefix' => 'http://127.0.0.1:81',
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
        // bin/country.bat 生成
        'country_uids' => array(
            'XA' => 1,
            'CN' => 156,
            'US' => 840,
        ),
    ),
    // 本地化
    'locale' => array(
        // bin/translate.bat 生成翻译文件
        'func' => '\php\func\lang', // 或者 gettext
        'domain' => '',
        'directory' => ROOT .'/conf/locale',
        'default_language' => 'en',
        // bin/language.bat 生成语言对应国家地区
        'available_languages' => array(
            'en' => 'US',
            'eo' = 'Esperanto',
            'zh' => 'CN',
            'zh-hant' => 'TW',
        ),
        'module' => array(
            '' => array(),
            'index' => array(
                'site_name' => 'URLNK.ORG',
                'login' => 'Sign in',
                'settings' => 'Settings',
                'search' => 'Search',
                'add' => 'Add',
            ),
            'user' => array(
                'site_nm' => 'URLNK.ORG',
                'login' => 'Sign in',
                'Settings',
                'acc_set' => 'Account settings',
                'usr_set' => 'User settings',
                'email' => 'E-mail',
                'phone' => 'Mobile phone',
                'logout' => 'Sign out',
                'passwd' => 'Password',
                'send_code' => 'Send verification code',
                'Sign up',
                'captcha' => 'Verification Code',
                'usr_reg' => 'User registration',
                'Account',
                'code_sent' => 'Verification code sent',
                'Sending',
                'cnfrm_pw' => 'Confirm password',
                'set_pw' => 'Set password',
                'chg_bind' => 'Change binding',
                'Binding',
                'New ',
            ),
        ),
    ),
    // 扩展
    'ext' => array(
        'geoip' => array(
            'custom_directory' => ini_get('geoip.custom_directory') ?: ROOT .'/data/geoip',
        ),
    ),
);
