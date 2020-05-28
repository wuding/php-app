<?php

namespace PhpApp\Example;

use MagicCube\Dispatcher;

class Index
{
    public $dispatcher = null;

    public function __construct($routeInfo)
    {
        $this->init($routeInfo);
    }

    public function init($routeInfo)
    {
        $config = include ROOT . '/app/module.php';
        $this->dispatcher = $dispatcher = new Dispatcher($routeInfo);
        $dispatcher->setVars($config);
    }

    public function dispatch($return = null)
    {
        return $result = $this->dispatcher->dispatch($return);
    }
}

$index = new Index($routeInfo);
$result = $index->dispatch(0);
# print_r($result);
