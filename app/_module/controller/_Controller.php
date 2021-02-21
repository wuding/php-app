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
        // 测试版，用户限制
        $stat = $_COOKIE['stat'] ?? null;
        if (!in_array($stat, array(1))) {
            header("Location: /");
            exit;
        }
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

    // 苹果设备图标请求
    public function appleTouchIcon()
    {
        $filename = ROOT .'/web/img/favicon.png';
        $size = filesize($filename);
        header("Content-Type: image/x-png");
        #header("Content-Length: $size");
        readfile($filename);
        exit;
    }

    public function appleTouchIconPrecomposed()
    {
        return $this->appleTouchIcon();
    }
}
