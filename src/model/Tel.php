<?php

namespace Model;

class Tel extends \Topdb\Table
{
    public $db_name = 'beings';
    public $table_name = 'tel_list';
    public $primary_key = 'id';

    public function get($sql)
    {
        $sth = $this->query($sql);
        return $sth->fetchObject();
    }

    public function getInfo($id)
    {
        $sql = "SELECT * 
FROM $this->db_name.$this->table_name 
WHERE $this->primary_key = '$id' 
LIMIT 1";

        $user = $this->get($sql);
        return $user;
    }

    public function select($sql)
    {
        return $this->db->select($sql);
        $sth = $this->query($sql);
        return $sth->fetchAll(\PDO::FETCH_OBJ);
    }
}
