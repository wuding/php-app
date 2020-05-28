<?php

namespace App\Contacts\Controller;

class Index extends \MagicCube\Controller
{
    public function index()
    {
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
