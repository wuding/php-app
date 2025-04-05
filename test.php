<?php

include 'J:\git\github.com\wuding\php-ext\future\src\Dir.php';
include 'J:\git\github.com\wuding\php-ext\future\src\Json.php';

include 'J:\git\github.com\wuding\php-ext\future\src\File.php';
include 'J:\git\github.com\wuding\php-ext\future\src\Link.php';

ksort($_SERVER);
print_r($_SERVER);
print_r($GLOBALS);die;
/*
$Link = new Ext\Link();
$sym = $Link->sym([], 'J:\git\github.com\wuding\php-ext\future\src', 'J:\git\github.com\wuding\php-app\future\src/ext');
var_dump($sym);
die;
*/
// $Json = new Json;
// $Json->encode([]);

$Dir = new Ext\Dir;
$scandir = $Dir->scandir(['directory' => 'J:\git\github.com\wuding\php-app\future'], 'directory');#, 'sort', 'c'
var_dump($scandir);

$a = [];
foreach ($scandir as $key) {
    $k = "$key\\";
    $a[$k] = $key .'/';
}

$a = json_encode($a, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
print_r($a);
