 <?php

 /**
  *
  * 导出国家 UID
  *
  */

define('ROOT', dirname(__DIR__));

$autoload = require ROOT ."/vendor/autoload.php";

use function php\func\globals;
use Pkg\Glob;
use app\user\model\User;

function country_uid($return = null)
{
    Glob::$conf = include ROOT .'/conf/develop.php';

    $m = new User;
    $arr = array();
    $all = $m->select("id, username", "id < 1000", "id");
    foreach ($all as $row) {
        $arr[$row->username] = (int) $row->id;
    }
    return $var = var_export($arr, $return);
}

function export() {
    $shortopts  = "o::";
    $longopts  = array(
        "output::",
    );
    $opt = getopt($shortopts, $longopts);
    $data = country_uid(true);
    $filename = globals('o', "country_". time() .".txt", $opt);
    return  $put = file_put_contents($filename, $data);
}

echo export();
