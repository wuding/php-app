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
        $where = $flags = [];
        foreach ($variable as $value) {
            if (array_key_exists($value, $arr)) {
               $where[$value] = $arr[$value];
            }
        }
        if (!$where) {
            print_r([get_defined_vars(), __FILE__, __LINE__]);
            exit;
        }
        if (is_array($return)) {
            $flags = $return;
            $return = in_array('row', $flags) ?: null;
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
            if (in_array('diff', $flags)) {
                return $diff;
            }

            $ignoreNull = in_array('null', $flags);
            $ignoreMin = in_array('min', $flags);

            $data = [];
            foreach ($diff as $key => $value) {
                list($val, $v) = $value;
                // 忽略小于
                if (is_numeric($val) && is_numeric($v) && $ignoreMin) {
                    if ($val <= $v) {
                        continue 1;
                    }
                }
                // 忽略空
                if (!is_numeric($val) && !trim($val) && $ignoreNull) {
                    continue 1;
                }
                $data[$key] = $val;
            }

            if (in_array('data', $flags)) {
                return $data;
            }
            if (!$data) {
                goto __END__;
            }

            $keys = array_keys($data);
            $data['updated'] = $data['compared'] = $time;
            $data['compares'] = $row->compares ? ['compares + 1'] : 1;
            $data['diff'] = implode(',', $keys);
            return $this->update($data, $row->$primary_key);
        }

        __END__:
        if ($return) {
            return $row;
        }
        return $row->$primary_key;
    }

    public function add($arr, $variable = null)
    {
        $time = time();
        $variable = $variable ?: $this->exist_fields;
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

        $row = $this->get($where, $this->primary_key);
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
        return false;
    }
}
