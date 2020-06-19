<?php
$filename = 'L:\Server\Mirror\https\music.163.com\discover\artist\cat\1001\cat90.htm';
$filename = 'L:\Server\Mirror\https\music.163.com\artist\12429072.html';
$contents = file_get_contents($filename);
$arr = [];
$string = 'x,script,html';
$filter = explode(',', $string);
if (preg_match_all('/<([a-z0-9]+)/', $contents, $matches)) {
    $variable = $matches[1];
    foreach ($variable as $value) {
        if (!is_numeric($value)) {
            if (isset($arr[$value])) {
                $arr[$value]++;
            } elseif (!in_array($value, $filter)) {
                $arr[$value] = 1;
            }
        }
    }
}

$pieces = array_keys($arr);
$allowable_tags = implode('><', $pieces);
echo strip_tags($contents, "<$allowable_tags>");
