<?php
namespace app\_module\controller;

use model\Glob;

class _Controller extends \MagicCube\Controller
{
    public $enableView = true;

    public function index()
    {
        return array('dir' => dirname(ROOT) .'\\', 'method' => __METHOD__, 'file' => __FILE__,  'line' => __LINE__);
    }

    public function _action()
    {
        http_response_code(404);
        echo "404 Not Found";
        exit;
        $uriInfo = $this->uriInfo;
        $this->uriInfo['action'] = '_action';
        return array('uriInfo' => $uriInfo, 'uri' => $this->uri, 'method' => __METHOD__, 'file' => __FILE__,  'line' => __LINE__);
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
            $destination = Glob::conf('upload_dir') .'/'. $file['name'];
            $move = move_uploaded_file($filename, $destination);
            print_r(get_defined_vars());
            exit;
        }
        return [];
    }
}
