<?php
return [
    # 'name' => 'nikic/fast-route',
    'name' => 'wuding/equiv-route',
    'routes' => [
        [['POST', 'GET'], '/admin/user[/{id:\d+}[/{name}]]', 'get_user_handler'],
        ['GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler'],
        ['GET', '/user/{name}', 'user_name_handler'],
        ['POST', '/users'],
        ['GET', '^/play/{id}', 'get,post:play!index@index'],
        ['GET', '^/{template:\d+}-{param}', 'url!redirect@index'],
        ['GET', '^/(|index.*)$', function(){ header("Location: /play");exit; }],
    ],
    'options' =>  [
        'cacheFile' => __DIR__ . '/../storage/cache/route.cache',
        'cacheDisabled' => 1,
    ],
    'status' => 1,
];
