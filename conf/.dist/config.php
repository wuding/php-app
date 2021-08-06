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
                'host' => 'localhost',
                'options' => array(
                    PDO::ATTR_PERSISTENT => true,
                ),
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
            #'REQUEST_URI' => '/music',
        ),
    ),
    // 地理位置
    'geo' => array(
        // bin/country.bat 生成
        'country_uids' => array(
            'XA' => 1,
            'AR' => 32,
            'AU' => 36,
            'MM' => 104,
            'CA' => 124,
            'CN' => 156,
            'TW' => 158,
            'CY' => 196,
            'CZ' => 203,
            'FI' => 246,
            'FR' => 250,
            'DE' => 276,
            'HK' => 344,
            'IN' => 356,
            'ID' => 360,
            'IT' => 380,
            'JP' => 392,
            'KR' => 410,
            'LT' => 440,
            'MY' => 458,
            'NL' => 528,
            'PA' => 591,
            'PL' => 616,
            'RO' => 642,
            'RU' => 643,
            'SG' => 702,
            'VN' => 704,
            'ZA' => 710,
            'ES' => 724,
            'SE' => 752,
            'UA' => 804,
            'GB' => 826,
            'US' => 840,
            'AP' => 922,
        ),
    ),
    // 本地化
    'locale' => array(
        // bin/translate.bat 生成翻译文件
        'func' => '\php\func\lang', // 或者 gettext
        'domain' => '',#zh
        'directory' => ROOT .'/conf/locale',
        'default_language' => 'en',
        // bin/language.bat 生成语言对应国家地区
        'available_languages' => array(
            'af' => 'ZA',
            'ar' => 'EG',
            'az' => 'AZ',
            'be' => 'BY',
            'bg' => 'BG',
            'bo' => 'Xizang',
            'ca' => 'ES',
            'co' => 'FR',
            'cs' => 'CZ',
            'cy' => 'Wales',
            'da' => 'DK',
            'de' => 'DE',
            'en' => 'US',
            'eo' => 'Esperanto',
            'es' => 'ES',
            'fa' => 'IR',
            'fil' => 'PH',
            'fr' => 'FR',
            'gl' => 'Galicia',
            'hi' => 'IN',
            'hu' => 'HU',
            'id' => 'ID',
            'it' => 'IT',
            'ja' => 'JP',
            'kk' => 'KZ',
            'ko' => 'KR',
            'la' => 'VA',
            'ms' => 'MY',
            'my' => 'MM',
            'nb' => 'NO',
            'ne' => 'NP',
            'nl' => 'NL',
            'no' => 'NO',
            'pl' => 'PL',
            'pt' => 'PT',
            'ro' => 'RO',
            'ru' => 'RU',
            'so' => 'SO',
            'sq' => 'AL',
            'su' => 'ID',
            'th' => 'TH',
            'tr' => 'TR',
            'ug' => 'Xinjiang',
            'uk' => 'UA',
            'und' => null,
            'vi' => 'VI',
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
    // 模块
    'module' => array(
        '*' => array('id', 'index', 'music', 'note', 'notes', 'search', 'user'),
        '/' => array('note', 'git',),
        '_' => array(
            'plural' => array(
                's' => array(
                    'n' => array('note'),
                ),
            ),
        ),
        'music' => array(
            'theme' => 'appleMusic',
        ),
        'note' => array(
            'alias' => 'notes',
            'controller' => array(
                'plural' => array(
                    's' => array(
                        'folder' => 302, // 0兼容 301永久转移 302转向
                        'user', // 兼容
                    ),
                ),
            ),
        ),
    ),
);
