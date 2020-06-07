<?php
// scandir.php

/**
扫描目录，去除当前和上级
添加目录前缀
**/
$directory = mb_convert_encoding($directory, 'UTF-8', 'GBK');
$files = scandir($directory ? : '.', $sorting_order ? 1 : 0);
unset($files[array_search('.', $files)]);
unset($files[array_search('..', $files)]);
$dir = trim(REQUEST_NAME, '/');
$dir = rawurldecode($dir);
if (!$drv_matches) {
    $dir = $_CONFIG['file_exists_dir'] .'/'. $dir;
}
$path = $dir ? '/' . $dir . '/' : '';
$lines = array("<a href=\"$path..\">..</a>");
$arr = [];
foreach ($files as $file) {
    $file = rawurldecode($file);
    $copy = null;
    $url = $path . $file;
    $filename = $dir .'/'. $file;
    $is_dir = is_dir($filename) ? '/' : '';
    $lines[] = "<a href=\"$url\">$file$is_dir</a>";

    /*
    // 文件检测统计，并复制到指定目录
    $target = "D:/Setup/Fonts/ttf/$file";
    $exists = file_exists($target);
    $copy = $exists ? '' : copy($filename, $target);
    $stat = stat($filename);
    foreach ($stat as $key => $value) {
        if (is_numeric($key)) {
            unset($stat[$key]);
        }
    }
    $arr[] = array(
        'filename' => $filename,
        'is_dir' => $is_dir,
        'stat' => $stat,
        'atime' => date('Y-m-d H:i:s', $stat['atime']),
        'ctime' => date('Y-m-d H:i:s', $stat['ctime']),
        'mtime' => date('Y-m-d H:i:s', $stat['mtime']),
        'exists' => $exists,
        'copy' => $copy,
    );
    */
}
$html = '<ol><li>' . implode('</li><li>', $lines) . '</li></ol>';
echo $html;
# print_r(json_encode($arr));
# echo date ("Y-m-d H:i:s", getlastmod());
