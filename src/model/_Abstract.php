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
    public function exists($arr, $return = null, $variable = null)
    {
        $primary_key = $this->primary_key;
        $time = time();
        $variable = $variable ? : $this->exist_fields;
        $where = [];
        foreach ($variable as $key => $value) {
            if ($arr[$value] ?? null) {
               $where[$value] = $arr[$value];
            }
        }
        $row = $this->get($where, '*');


        if (!$row) {
            $data = [
                'status' => -1,
                'created' => $time,
                'updated' => $time,
            ];
            $arr += $data;
            return $this->insert($arr);
        }

        $diff = $this->array_diff_kv($arr, (array) $row);

        if ($diff) {
            $data = [];
            foreach ($diff as $key => $value) {
                $data[$key] = $value[0];
            }
            $keys = array_keys($diff);
            $data['updated'] = $data['compared'] = $time;
            $data['compares'] = $row->compares ?? 0 + 1;
            $data['diff'] = implode(',', $keys);

            return $this->update($data, $row->$primary_key);
        }
        if ($return) {
            return $row;
        }
        return $row->$primary_key;
    }

    /**
     * 比较数组的键值
     * @param  array $arr    要比较的数组
     * @param  array $other  对比数组
     * @param  array $ignore 忽略键名
     * @param  bool  $null   附上键或值为null的项
     * @return array         返回值不同的键名
     */
    public function array_diff_kv($arr = [], $other = [], $ignore = [], $null = false)
    {
        foreach ($ignore as $row) {
            unset($arr[$row]);
        }

        $diff = [];
        foreach ($arr as $key => $value) {
            if (array_key_exists($key, $other)) {
                if ($value != $val = $other[$key]) {
                    $diff[$key] = [$value, $val];
                }
            } elseif($null) {
                $diff[$key] = null;
            }
        }
        return $diff;
    }
}
