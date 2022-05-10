<?php

namespace app\test\src\controller;

class Index extends \MagicCube\Controller
{
    public function __construct($vars = array())
    {
        if (is_numeric($vars['uriInfo']['controller'])) {

        }
        parent::__construct($vars);print_r($vars);
    }

    public static function index()
    {
        return get_defined_vars();
    }
}
