<?php

namespace App\Contacts\Controller;

class _Controller extends \MagicCube\Controller
{
    public function index()
    {
        print_r(array(__FILE__, __LINE__));
    }

    public function _action()
    {
        $uriInfo =& $this->uriInfo;
        $num = $uriInfo['action'];
        if (preg_match('/\d+/i', $num, $matches)) {
            $uriInfo['action'] = 'contact';
            return $this->contact($num);
        }
        print_r(array(__FILE__, __LINE__));
    }

    public function contact($id)
    {
        $Tel = new \Model\Tel;
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $t = $_POST['type'];
            $n = $_POST['text'];
            $app_id = $_POST['app_id'] ?? -1;
            $no = addslashes($n);
            switch ($t) {
                case 'addr':
                    $sql = "INSERT INTO beings.contact_address SET contact_id = $id, location = '$no'";
                    break;

                case 'tel':
                    $sql = "INSERT INTO beings.contact_phone SET contact_id = $id, phone_number = '$no'";
                    break;

                default:
                    $sql = "INSERT INTO beings.contact_app SET contact_id = $id, app_account = '$no', app_id = '$app_id'";
                    break;
            }
            $ins = $Tel->query($sql);
        }

        $sql = "SELECT * FROM beings.`contact_item` WHERE id = $id";
        $row = $Tel->get($sql);

        $sql = "SELECT * FROM beings.`contact_phone` WHERE `contact_id` = '$id' LIMIT 50";
        $all = $Tel->select($sql);

        $sql = "SELECT A.*, B.name 
FROM beings.`contact_app` A 
LEFT JOIN application.app_list B ON B.id = A.app_id 
WHERE `contact_id` = '$id' 
ORDER BY `app_id` 
LIMIT 50";
        $app = $Tel->select($sql);

        $sql = "SELECT id, name FROM application.`app_list` LIMIT 50";
        $apps = $Tel->select($sql);

        $sql = "SELECT id, location FROM beings.`contact_address` WHERE `contact_id` = '$id' LIMIT 50";
        $addr = $Tel->select($sql);
        return get_defined_vars();
    }

    public function add()
    {
        $uriInfo =& $this->uriInfo;
        $uriInfo['action'] = 'contact-add';

        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $Tel = new \Model\Tel;
            $n = $_POST['name'];
            $name = addslashes($n);
            $nu = rawurlencode($n);
            $sql = "INSERT INTO beings.contact_item SET NickName = '$name'";
            $ins = $Tel->query($sql);
            $url = "/contacts?q=$nu";
            header("Location: $url");
            exit;
        }

        return get_defined_vars();
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
