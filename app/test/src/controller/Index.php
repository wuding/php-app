<?php

namespace app\test\src\controller;

class Index extends \MagicCube\Controller
{
    const VERSION = '23.6.3';
    public static $srcDir = 'src';
    protected $enableView = true;

    public function __construct($vars = array())
    {
        if (is_numeric($vars['uriInfo']['controller'])) {
            print_r($vars);
        }
        parent::__construct($vars);
    }

    public static function index()
    {
        return get_defined_vars();
    }
}
