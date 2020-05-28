<?php

namespace App\_Error\Controller;

class _Controller extends \MagicCube\Controller
{
    public $enableView = false;

    public function index()
    {
        print_r(array(__FILE__, __LINE__));
    }

    public function _action()
    {
        print_r(array(__FILE__, __LINE__));
    }

    public function route()
    {
        print_r(array(__FILE__, __LINE__));
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
