<?php
namespace model;

use PDO;

class _Abstract extends \Topdb\Table
{
    public function offset($offset = null, $site_id = null, $column = '*')
    {
        $sql = "SELECT $column
FROM $this->table_name
WHERE `site` = '$site_id'
ORDER BY `id`
LIMIT 1
OFFSET $offset";

        return $this->query($sql, PDO::FETCH_OBJ);
    }

    public function list($offset = null, $site_id = null, $limit = 100, $column = '*')
    {
        $sql = "SELECT $column
FROM $this->table_name A
INNER JOIN (
SELECT id
FROM $this->table_name
WHERE `site` = '$site_id'
ORDER BY `id`
LIMIT $limit
OFFSET $offset
) B ON A.id = B.id";

        return $this->query($sql, PDO::FETCH_OBJ);
    }

    /**
     * 检测
     * @param  array  $arr 查询及设置数据
     * @return integer     条目ID或更新状态
     */
    public function exists($arr, $return = null, $variable = null, $column = '*')
    {
        $primary_key = $this->primary_key;
        $time = time();
        $variable = $variable ? : $this->exist_fields;
        $where = [];
        foreach ($variable as $value) {
            if (array_key_exists($value, $arr)) {
               $where[$value] = $arr[$value];
            }
        }
        if (!$where) {
            print_r([get_defined_vars(), __FILE__, __LINE__]);
            exit;
        }

        // 列名
        if ('*' === $column) {
            goto __GET__;
        } elseif (true === $column) {
            $split = array_keys($arr);
        } else {
            $split = preg_split('/,\s*/', $column);
        }
        // 加上后面用到的列名
        $trans = arr_merge(array_values($split), [$primary_key, 'compares']);
        $column = implode(', ', $trans);

        __GET__:
        $row = $this->get($where, $column);
        // 不存在则插入
        if (!$row) {
            $data = [
                'status' => -1,
                'created' => $time,
                'updated' => $time,
            ];
            $arr += $data;
            return $this->insert($arr);
        }

        $diff = array_diff_kv($arr, (array) $row);
        // 不同则更新
        if ($diff) {
            $data = [];
            foreach ($diff as $key => $value) {
                $data[$key] = $value[0];
            }
            $keys = array_keys($diff);
            $data['updated'] = $data['compared'] = $time;
            $data['compares'] = $row->compares ? ['compares + 1'] : 1;
            $data['diff'] = implode(',', $keys);
            return $this->update($data, $row->$primary_key);
        }

        if ($return) {
            return $row;
        }
        return $row->$primary_key;
    }
}
