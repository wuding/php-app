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
$dir = $dir ? '/' . $dir . '/' : '';
$lines = array("<a href=\"$dir..\">..</a>");
foreach ($files as $file) {
    $lines[] = "<a href=\"$dir$file\">$file</a>";
}
$html = '<li>' . implode('</li><li>', $lines) . '</li>';
echo $html;
