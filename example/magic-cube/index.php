<?php

namespace PhpApp\Example;

use MagicCube\Dispatcher;

class Index
{
    const VERSION = '20.213.237';
    public $dispatcher = null;

    public function __construct($routeInfo, $httpMethod)
    {
        $this->init($routeInfo, $httpMethod);
    }

    public function init($routeInfo, $httpMethod)
    {
        $config = include ROOT . '/app/module.php';
        $this->dispatcher = $dispatcher = new Dispatcher($routeInfo, $httpMethod);
        $dispatcher->_setVars($config);
    }

    public function dispatch($return = null)
    {
        return $result = $this->dispatcher->dispatch($return);
    }
}

$index = new Index($routeInfo, $httpMethod);
$result = $index->dispatch($_CONFIG['debug']);
if ($_CONFIG['debug']) {
    print_r(array($result, __FILE__, __LINE__));
}

if (null !== $_CONFIG['debug']) {
    $files = get_included_files();
    // 合并漏掉的
    extract(\Ext\Yac::hash('files', 'files_', 1));
    foreach ($cacheValue as $key => $value) {
        if (!in_array($value, $files)) {
            $files[] = $value;
        }
    }
    // 排序
    if (false === $_CONFIG['debug']) {
        sort($files);
    }
    print_r(array($files, __FILE__, __LINE__));
}

/* vendor/composer/ClassLoader.php findFile()
extract(Yac::hash('files', 'files_', 1));
$arr = [];
if (false !== $cacheValue) {
    $arr = (array) $cacheValue;
}
$arr[$class] = realpath($file);
Yac::store($cacheKey, $arr, 30, 1);
*/
