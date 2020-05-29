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
        print_r(array($this, __FILE__, __LINE__));
    }

    public function _error()
    {
        print_r(array(__FILE__, __LINE__));
    }

    public function contacts()
    {
        print_r(array(__FILE__, __LINE__));
    }

    public function get_user_handler()
    {
        print_r(array($this, __FILE__, __LINE__));
    }

    public function get_article_handler()
    {
        print_r(array($this, __FILE__, __LINE__));
    }

    public function user_name_handler()
    {
        print_r(array($this, __FILE__, __LINE__));
    }

    public function users()
    {
        print_r(array($this, __FILE__, __LINE__));
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
