 <?php

 /**
  *
  * 从消息 ID（英文）列表生成散列值
  * 同时生成可用语言键名，用于翻译
  *
  */

define('ROOT', dirname(dirname(__DIR__)));

$autoload = require ROOT ."/vendor/autoload.php";

use function php\func\{lang, globals, get};
use Pkg\Glob;

// 从消息 ID 生成翻译列表，合并已有翻译
function translate($return = null, $sort = null, $detail = null, $filter = null, $list = null, $file = null) {
    Glob::$conf = include ROOT .'/conf/develop.php';
    $id = include ROOT ."/conf/locale/msgid.php";
    $filename = ROOT ."/conf/locale/messages";
    $messages = include $filename .".php";

    // 类型检查
    if (!is_array($messages)) {
        var_dump(array('file' => __FILE__, 'line' => __LINE__, get_defined_vars()));
        exit;
    }

    $GLOBALS['messages'] = $messages ?: array();
    $arr = $english = $table = $prt = array();
    $languages = Glob::conf('locale.available_languages');
    $variable = preg_split("/\r\n/", $id);
    $filename = $file ?: $filename;

    // 遍历 msgid
    foreach ($variable as $value) {
        $hash = lang($value, true);

        $array = array();
        foreach ($languages as $key => $val) {
            $lang = Glob::get($key);
            if (!$lang) {
                $lang = @include ROOT ."/conf/locale/$key/LC_MESSAGES/messages.php";
                $lang = $lang ?: array();
                $set = Glob::set($key, $lang);
            }
            $itm = globals("$hash.$key", '', 'messages');
            $item = $itm ?: globals($hash, '', $lang);
            $array[$key] = $item;
        }
        if (!$array['en']) {
            $array['en'] = $value;
        }
        $arr[$hash] = $array;
        $english[$hash] = $en = $array['en'];
        $table[$en] = $hash;
    }

    // 排序
    if (1 === $sort) {
        sort($english);
    } elseif (2 === $sort) {
        ksort($english);
    }
    foreach ($english as $key => $value) {
        $hash = 1 === $sort ? $table[$value] : $key;
        $prt[] = $hash .' '. $value;
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
    $result = $haystack = array();
    foreach ($languages as $key => $val) {
        $translate = export($key, $arr, true, $detail);
        $status = $translate['count'] ?? null;
        if (array_key_exists('str', $translate)) {
            $translate = $translate['str'];
        }
        if ($status) {
            // 不显示有翻译的
            if (2 === $filter) {
            } else {
                $result[] = $translate;
                $haystack[] = $key;
            }
        } else {
            // 不显示无翻译的
            if (1 === $filter) {
            } else { // 显示所有
                $result[] = $translate;
                $haystack[] = $key;
            }
        }
    }

    // 语言列表
    if (is_numeric($list)) {
        foreach ($languages as $key => $value) {
            // 删除不显示详情的
            if (1 === $list && !in_array($key, $haystack)) {
                unset($languages[$key]);
            } elseif (2 === $list && in_array($key, $haystack)) { // 删除显示详情的
                unset($languages[$key]);
            }
        }
    }

    // 返回
    $result['summary'] = array(
        'total' => count($result),
        'put' => $put,
        'file' => $filename,
        'count' => count($arr),
        'en' => $prt,
        'sort' => $sort,
        'detail' => $detail,
        'filter' => $filter,
    );
    $result['languages'] = array(
        'count' => count($languages),
        'arr' => $languages,
        'list' => $list,
    );
    return print_r($result, $return);
}

// 合并本地化语言翻译，导出并返回详情
function export($lang, $variable, $output = null, $detail = null) {
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
    $put = file_put_contents($filename, $data);

    // 忽略空值
    foreach ($arr as $key => &$value) {
        if (!$value) {
            unset($arr[$key]);
        }
    }

    // 返回
    // 数组详情
    if (2 === $detail) {
        return $str = array(
            'lang' => $lang,
            'put' => $put,
            'file' => $filename,
            'count' => count($arr),
            'arr' => $arr,
        );
    }

    // 字符串描述
    $str = "$lang, $put";
    if (1 === $detail) {
        $str .= ", $filename";
    }
    $str = array(
        'count' => count($arr),
        'str' => $str,
    );
    return $str;
}

// 获取命令行参数
function options($short = null, $long = null) {
    $shortopts  = "o::s::d::f::l::";
    $longopts  = array(
        "output::",
    );
    $opt = getopt($shortopts, $longopts);
    return $opt;
}

// 参数默认值和类型，支持自定义键名
function args($opts = array()) {
    // 参数名 => 默认值不可以是 null，键名可选
    $variable = array(
        'o' => array('translate.txt', 'output'),
        's' => array(0, 'sort'),
        'd' => array(0, 'detail'),
        'f' => array(0, 'filter'),
        'l' => array(0, 'list'),
    );
    $arr = array();
    foreach ($variable as $key => $value) {
        // 仅参数名
        if (is_numeric($key)) {
            $key = $value;
            $value = null;
        }
        $k = $key;
        $v = $value;
        // 配置了键值对
        if (is_array($value)) {
            $k = ($value[1] ?? null) ?: $k;
            $v = $value[0] ?? $v;
        }
        $val = globals($key, $v, $opts, false);
        // 整数类型
        if (!in_array($key, array('o'))) {
            if (is_numeric($val)) {
                $val = (int) $val;
            }
        }
        $arr[$k] = $val;
    }
    return $arr;
}

// 命令行
if ('cli' === php_sapi_name()) {
    extract(args(options()));
} else { // Web
    $arr = get(array('sort', 'detail' => 2, 'filter', 'list', 'output' => ''));
    foreach ($arr as $key => &$value) {
        // 整数类型
        if (!in_array($key, array('output'))) {
            if (is_numeric($value)) {
                $value = (int) $value;
            }
        }
    }
    extract($arr);
    // 默认不输出，因为浏览器已经打印
    $output = '1' === $output ? 'translate.txt' : $output;
}

$translate = translate(true, $sort, $detail, $filter, $list);
print_r($translate);

// 导出所有输出结果
if ($output) {
    $put = file_put_contents($output, $translate);
    $filename = realpath($output);
    echo $filename . PHP_EOL;
    var_dump($put);
}
