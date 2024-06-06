 <?php

 /**
  *
  * 导出国家 UID
  *
  */

defined('ROOT') ?: define('ROOT', dirname(dirname(__DIR__)));

$autoload = require ROOT ."/vendor/autoload.php";

use Pkg\Glob;
use app\user\src\model\User;

function country_uid($return = null, $max_id = 1000)
{
    Glob::$conf = include ROOT .'/conf/develop.php';

    $m = new User;
    $arr = array();
    $all = $m->select("id, username", "id < $max_id", "id") ?: array();
    foreach ($all as $row) {
        $arr[$row->username] = (int) $row->id;
    }

    //=g
    if (is_numeric($return)) {
        return $arr;
    }
    return var_export($arr, $return);
}

$data = country_uid(1);
print_r(array('count' => count($data), 'country' => $data));

// 导出所有输出结果
$output = "country.txt";
$country = var_export($data, true);
$put = file_put_contents($output, $country);
$filename = realpath($output);
echo $filename . PHP_EOL;
var_dump($put);
