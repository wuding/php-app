<?php

namespace app\_module\controller;

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

    public function upload()
    {
        global $_CONFIG;
        $this->enableView = true;
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $file = $_FILES['_'];
            $filename = $file['tmp_name'];
            $destination = $_CONFIG['upload_dir'] .'/'. $file['name'];
            $move = move_uploaded_file($filename, $destination);
            print_r(get_defined_vars());
            exit;
        }
        return [];
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
