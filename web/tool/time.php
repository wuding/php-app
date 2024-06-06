<?php

$min = 60;

for ($i = 0; $i < 25; $i++) {
    $j = $min * $i;
    echo $i .'='. $j . PHP_EOL;
}

# echo 0 . PHP_EOL;
$ten = 10;
for ($i = 0; $i < 144; $i++) {
    $j = $ten * $i;
    $k = $j + $ten;
    $l = $j / 60;
    $m = $j % 60;
    $o = floor($l);
    $p = preg_replace("/0$/", '', $j);
    $n = "$p $o $m";
    echo $n . PHP_EOL;
}
