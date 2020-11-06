<?php

defined('ENV_DIR') or define('ENV_DIR', 'I:\env');

return array(
    'stat' => null,
    'rewrite_file' => BASE_DIR . '/web/rewrite.php',
    'static_home' => false,
    'debug' => $_GET['debug'] ?? null,
    'file_exists_dir' => 'N:\Server\VCS\Git\github\devops-env\env',
    'extensions' => 'js|png|jpg|jpeg|gif|ico',
    'router_extensions' => 'vtt|css|js|png|jpg|jpeg|gif|ico',
    'supported_ext' => ['mp4', 'mp3', 'aac', 'm4a'],
    'videojs_ext' => [],
    'dplayer_ext' => ['m3u8', 'torrent'],
    'upload_dir' => 'N:\Server\Upload',
    'downloadDir' => 'N:\Server\Download',
    'cacheDir' => 'N:\Server\Mirror',
    'outputCallback' => [
        'gz' => 'outputCallback.gz',
    ],
    'gzip' => 'on0',
    'artistResultSet' => [
        'songsSets', 'privilegeSets',
        # 'hotSongs', 'privilege',
        # 'raw', 'data',
        'info', 'songs',
    ],
    'example' => 'magic-cube/index',
    'time_limit' => 180,
    'timezone' => 'PRC',
    'uri_custom' => '',
    # 'uri_custom' => 'get,post:users!wubenli@documents$1%2Fview', //$1
    'virtual_paths' => array(
        '' => array(
            '/^[a-z]{4}(.*)$/' => 'filename',
        ),
        'filename' => ENV_DIR . '/www/.dist/a-z7.php',
    ),
    'virtual_hosts' => array(),
    'host_domain' => '.loc.urlnk.com',
    'database_contect' => 'database',
    'database' => array(
        'db_name' => '',
        'username' => '',
        'password' => '',
        'host' => '192.168.100.4',
        'port' => '3306',
        'driver_options' => [PDO::ATTR_TIMEOUT => 100],
        'keys_clean' => false,
    ),
    'database_srv' => array(
        'db_name' => '',
        'username' => '',
        'password' => '',
        'host' => '',
        'port' => '',
    ),
    'db' => array(
        'dbname' => '',
        'username' => '',
        'password' => '',
        'host' => '192.168.100.4',
    ),
    'redis' => array(
        'host' => '127.0.0.1',
        'port' => 6379,
        'auth' => '',
        'dbindex' => 15,
        'stat_dbindex' => 14,
    ),
    'session' => array(
        'name' => 'SID',
        'cookie' => array(
            'lifetime' => 864000000,
            'path' => '/',
            'httponly' => true,
        ),
    ),
    'template' => array(
        'output_callback' => null, // false 使用默认 null 不使用任何
    ),
    'func' => [
        'config' => [],
        'load' => ['arr', 'variable'],
    ],
    'host' => array(
        'name' => array(
            '127.0.0.1',
            '192.168.100.4'
        ),
        'location' => 'http://127.0.0.1',
        'remote_addr' => array(

        ),
    ),
    'query' => [
        'allow' => ['q', 'page', 'people'],
        'remove' => ['disabled']
    ],
    'banned' => array(
        'ua' => array(11),
        'ip' => array(
            #'127.0.0.1'
        ),
    ),
    'ttl' => array(
        'ua' => 86400,
    ),
    'log' => array(
        'ignore_ip' => array(//'127.0.0.1',
            '103.242.135.246',
        ),
    ),
);
