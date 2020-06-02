<?php
// scandir.php

/**
扫描目录，去除当前和上级
添加目录前缀
**/
$files = scandir($directory ? : '.', $sorting_order ? 1 : 0);
unset($files[array_search('.', $files)]);
unset($files[array_search('..', $files)]);
$dir = trim(REQUEST_NAME, '/');
$path = $dir ? '/' . $dir . '/' : '';
$lines = array("<a href=\"$path..\">..</a>");
$arr = [];
foreach ($files as $file) {
    $copy = null;
    $url = $path . $file;
    $filename = $dir .'/'. $file;
    $lines[] = "<a href=\"$url\">$file</a>";

    /*
    // 文件检测统计，并复制到指定目录
    $target = "D:/Setup/Fonts/ttf/$file";
    $exists = file_exists($target);
    $stat = stat($filename);
    foreach ($stat as $key => $value) {
        if (is_numeric($key)) {
            unset($stat[$key]);
        }
    }
    if (!$exists) {
        $copy = copy($filename, $target);
    }
    $arr[] = array(
        'filename' => $filename,
        'stat' => $stat,
        'atime' => date('Y-m-d H:i:s', $stat['atime']),
        'ctime' => date('Y-m-d H:i:s', $stat['ctime']),
        'mtime' => date('Y-m-d H:i:s', $stat['mtime']),
        'exists' => $exists,
        'copy' => $copy,
    );
    */
}
$html = '<li>' . implode('</li><li>', $lines) . '</li>';
echo $html;
# print_r(json_encode($arr));
# echo date ("Y-m-d H:i:s", getlastmod());
