<?php

namespace app\favicon\controller;

class _Controller extends \MagicCube\Controller
{
    public static $config = null;

    public function __construct($vars = null)
    {
        parent::__construct($vars);
        self::$config = include dirname(__DIR__) .'/config.php';
        $this->pathinfo = pathinfo($this->uri);
        $this->ext = strtolower($this->pathinfo['extension'] ?? null);
        #print_r($this);
    }

    public function __call($name, $args)
    {
        if ('ico' === $this->ext) {
            $filename = self::$config['favicon.ico'];
            $size = filesize($filename);
            header("Content-Type: image/x-icon");
            header("Content-Length: $size");
            readfile($filename);
            exit;
        }
        print_r([func_get_args(), __FILE__, __LINE__]);
        exit;
    }
}
