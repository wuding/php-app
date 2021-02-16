<?php

namespace src\model;

class Schema extends \Topdb\Tbl
{
    public function __construct($vars = null, $prop = null, $config = null, $merge = null)
    {
        // 不包含导入
        if (is_object($config)) {
            $conf = (array) $config;
        } else { // 导入配置
            $conf = include $this->config_file;
            $conf = $conf['model'];
            // 合并
            if (is_array($config)) {
                if (false !== $merge) {
                    $conf = array_merge($conf, $config);
                }
            }
        }
        parent::__construct($vars, $prop, $conf);
    }
}
