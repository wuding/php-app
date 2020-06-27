<?php
namespace app\_error\controller;

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
        print_r(array($this, __FILE__, __LINE__));
    }
}
