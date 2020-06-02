<?php
# echo $request_urn;

$filename = 'D:\System\Users\Administrator\.bash_history';
$filenm = 'C:\Users\Administrator\.bash_history';
$fileinfo = $filename . '.json';

$stat = stat($filename);
$sta = stat($filenm);
$fmd = md5_file($filename);
$fm = md5_file($filenm);
$md = md5($filename);
$m = md5($filenm);
$name = file_get_contents($filename);
$nm = file_get_contents($filenm);
$info = file_get_contents($fileinfo);
$inf = json_decode($info);

if ($inf) {
    $ar = (array) $inf[0];
    $stats = (array) $inf[1];
    $contents = (array) $inf[2];
    if (array_key_exists($m, $ar)) {
        if ($ar[$m] != $fm) {
            echo set_file_md5($fileinfo, $m, $fm, $nm, $sta, $ar, $contents, $stats);
        } else {
            echo get_file_text($fileinfo);
            echo __FILE__;
            exit;
        }
    } else {
        echo set_file_md5($fileinfo, $m, $fm, $nm, $sta, $ar, $contents, $stats);
    }

} else {
    $ar = [$md => $fmd];
    $stats = [$md => $stat['mtime']];
    $contents = [$md => $name];
    echo set_file_md5($fileinfo, $m, $fm, $nm, $stat, $ar, $contents, $stats);
}

function set_file_md5($filename, $key, $md5, $text, $stat, $ar = [], $contents = [], $stats = []) {
    $ar[$key] = $md5;
    $contents[$key] = $text;
    $stats[$key] = $stat['mtime'];
    $json = json_encode(array($ar, $stats, $contents));
    return file_put_contents($filename, $json);
}

function get_file_text($fileinfo) {
    $info = file_get_contents($fileinfo);
    $inf = json_decode($info);
    $tm = (array) $inf[1];
    $arr = (array) $inf[2];
    $str = '';
    $times = array();
    $time = array();
    foreach ($tm as $key => $value) {
        if (isset($times[$value])) {
            $times[$value]++;
        } else {
            $times[$value] = 0;
        }
        $k = $value + $times[$value];
        $time[$k] = $key;
    }
    ksort($time);
    foreach ($time as $key => $value) {
        $str .= $arr[$value] . PHP_EOL;
    }
    return $str;
}

$str = get_file_text($fileinfo);
echo file_put_contents($filename, $str);
