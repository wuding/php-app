<?php

namespace src\model;

class Schema extends \Topdb\Tbl
{
    const VERSION = 25.0703;
    const REVISION = 3;
    public static $conf_file = null;
    public $times = array(
        'created' => '23.6.5 16:47',
        'modified' => ['23.6.5 17:57', '23.6.8 15:04'],
        'updated' => [
            23 => [
                6 => [
                    5,
                ],
            ],
        ],
    );

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

        $connect = $conf['Db']['connect'] ?? null;
        unset($conf['Db']['connect']);
        parent::__construct($vars, $prop, $conf, $connect);
    }
}
