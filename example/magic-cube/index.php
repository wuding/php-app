<?php

namespace PhpApp\Example;

use MagicCube\Dispatcher;

class Index
{
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
