<?php

namespace App\_Module\Controller;

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

    public function _error()
    {
        print_r(array(__FILE__, __LINE__));
    }

    public function contacts()
    {
        print_r(array(__FILE__, __LINE__));
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
