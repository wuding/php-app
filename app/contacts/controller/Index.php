<?php

namespace App\Contacts\Controller;

class Index extends \MagicCube\Controller
{
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
        return get_defined_vars();
    }
}
