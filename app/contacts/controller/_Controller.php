<?php

namespace App\Contacts\Controller;

class _Controller extends \MagicCube\Controller
{
    public $enableView = false;

    public function index()
    {
        $uriInfo =& $this->uriInfo;
        $params = explode('/', $uriInfo['param']);
        $num = array_shift($params);

        // 动作匹配
        if (preg_match('/\d+/i', $num, $matches)) {
            $uriInfo['action'] = 'contact';
            return $this->contact($num);
        } elseif ('Index' != $num && preg_match('/[a-z]+/i', $num, $matches)) {
            $method = strtolower($num);
            return $this->$method();
        }

        $q = isset($_GET['q']) ? $_GET['q'] : '';
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $where = '';
        if ($q) {
            $where = "`NickName` LIKE '%$q%'";
        }
        $w = $where ? ' WHERE ' . $where : '';
        $offset = $page * 50 - 50;

        $Tel = new \Model\Tel;
        $sql = "SELECT id, NickName FROM beings.`contact_item` $w LIMIT $offset,50";
        $all = $Tel->select($sql);
        print_r(get_defined_vars());exit;
        return get_defined_vars();
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
        print_r(get_defined_vars());exit;
        return get_defined_vars();
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
