 <?php

 /**
  *
  * 从消息 ID（英文）列表生成散列值
  * 同时生成可用语言键名，用于翻译
  *
  */

define('ROOT', dirname(__DIR__));

$autoload = require ROOT ."/vendor/autoload.php";

use function php\func\{lang, globals};
use Pkg\Glob;

function translate($return = null) {
    Glob::$conf = include ROOT .'/conf/develop.php';
    $id = include ROOT ."/conf/locale/msgid.php";
    $filename = ROOT ."/conf/locale/messages";
    $GLOBALS['messages'] = include $filename .".php";
    $arr = array();
    $languages = Glob::conf('locale.available_languages');
    $variable = preg_split("/\r\n/", $id);

    // 遍历 msgid
    foreach ($variable as $value) {
        $hash = lang($value, true);

        $array = array();
        foreach ($languages as $key => $val) {
            $lang = Glob::get($key);
            if (!$lang) {
                $lang = @include ROOT ."/conf/locale/$key/LC_MESSAGES/messages.php";
                $set = Glob::set($key, $lang ?: array());
            }
            $itm = globals("$hash.$key", '', 'messages');
            $item = $itm ?: globals($hash, '', $lang);
            $array[$key] = $item;
        }
        if (!$array['en']) {
            $array['en'] = $value;
        }
        $arr[$hash] = $array;
    }

    // 写入散列表
    $data = '<?php
/* Hash table */
return ';
    $data .= var_export($arr, true);
    $data .= ';
';
    $put = file_put_contents($filename, $data);

    // 导出翻译
    $result = array();
    foreach ($languages as $key => $val) {
        $result[$key] = $translate = export($key, $arr, true);
    }
    return print_r($result, $return);
}

function export($lang, $variable, $output = null) {
    $dir = ROOT ."/conf/locale/$lang/LC_MESSAGES";
    $conf = $dir ."/messages.php";
    $filename = $dir ."/$lang.lng";
    $translate = @include $conf;
    $GLOBALS["translate.$lang"] = $translate ?: array();

    // 遍历语言
    foreach ($variable as $hash => $value) {
        $val = globals($lang, '', $value);
        $item = $val ?: globals($hash, $val, "translate.$lang");
        $arr[$hash] = $item;
    }

    // 翻译结果
    if (!$output) {
        return $arr;
    }

    // 新建目录
    if (!is_dir($dir)) {
        $mk = mkdir($dir, 0777, true);
    }

    // 写入语言文件
    $data = "<?php
/* $lang */
return ";
    $data .= var_export($arr, true);
    $data .= ';
';
    return $put = file_put_contents($filename, $data);
}

translate();
