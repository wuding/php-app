<?php

return array(
    'rewrite_file' => BASE_DIR . '/web/rewrite.php',
    # 'rewrite_file' => '',
    'debug' => 0,
    'file_exists_dir' => '',
    'extensions' => 'js|png|jpg|jpeg|gif|ico',
    'router_extensions' => 'png|jpg|jpeg|gif|ico',
    'example' => 'magic-cube/index',
    'time_limit' => 30,
    'uri_custom' => '',
    # 'uri_custom' => 'get,post:users!wubenli@documents$1%2Fview', //$1
    'virtual_paths' => array(),
    'virtual_hosts' => array(),
    'host_domain' => '',
    'database_contect' => 'database',
    'database' => array(
        'db_name' => '',
        'username' => '',
        'password' => '',
        'host' => '',
    ),
    'database_srv' => array(
        'db_name' => '',
        'username' => '',
        'password' => '',
        'host' => '',
        'port' => '',
    ),
);
