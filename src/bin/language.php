 <?php

 /**
  *
  * 从数据库读取语言列表
  * 生成语言与国家的键值对，并导出
  *
  */

define('ROOT', dirname(dirname(__DIR__)));

$autoload = require ROOT ."/vendor/autoload.php";

use app\index\model\LangStr;
use Pkg\Glob;

function language($return = null)
{
    //=s
    Glob::$conf = include ROOT .'/conf/develop.php';
    $languages = Glob::conf('locale.available_languages');
    $LangStr = new LangStr;

    //=f
    $arr = $array = array();

    //=z
    ksort($languages);

    //=sh
    $all = $LangStr->select('str, country', "pid = 0 OR sup = 1", 'str');
    foreach ($all as $row) {
        $key = strtolower($row->str);
        $arr[$key] = $row->country;
    }

    //=l
    foreach ($languages as $key => $value) {
        if (!array_key_exists($key, $arr)) {
            $o[$key] = $value;
        }
    }

    //=j
    if ($array) {
        print_r(array(__FILE__, __LINE__, $array));
    }

    //=g
    if (is_numeric($return)) {
        return $arr;
    }
    return var_export($arr, $return);
}

$data = language(1);
print_r(array('count' => count($data), 'language' => $data));

// 导出所有输出结果
$output = "language.txt";
$language = var_export($data, true);
$put = file_put_contents($output, $language);
$filename = realpath($output);
echo $filename . PHP_EOL;
var_dump($put);
