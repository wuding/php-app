<?php

// version 260630.1

$pattern = "#([0-9\.]+)#";
$f = "J:/Server/Mirror/https/www.zdaye.com/free.html";
$d = new DOMDocument;
@$d->loadHTMLFile($f);
$variable = $d->getElementsByTagName('ul');

$a = [];
foreach ($variable as $key => $value) {
  $c = $value->getAttribute('class');
  if ('ul-row' != $c) {
    continue;
  }

  $var = $value->getElementsByTagName('p');

  $r = [];
  foreach ($var as $k => $v) {
    $cl = $v->getAttribute('class');
    if (!in_array($cl, ['proxy_ip', 'proxy_port'])) {
      break;
    }
    preg_match($pattern, $v->nodeValue, $matches);
    // print_r([$k, $v->nodeValue, $matches[1]]);
    $r[$cl] = $matches[1];
  }

  $h = $r['proxy_ip'] .':'. $r['proxy_port'];
  $a[] = $h;
}

sort($a);
print_r($a);


$b = [
      1 => '120.92.211.211:7890',//
      2 => '115.231.181.40:8128',//
      3 => '47.112.25.109:7890',
      4 => '116.171.106.26:3443',
      5 => '43.207.141.180:443',
      6 => '15.152.75.215:44641',
      7 => '16.51.148.102:13426',
      8 => '35.73.28.87:3128',
      9 => '47.98.219.185:8999',//
      10 => '47.52.134.234:36463',
      11 => '8.154.21.175:3128',
      12 => '120.92.212.16:8890',//
      13 => '111.48.191.1:7890',//
      14 => '111.79.111.126:3128',//
      15 => '114.94.148.37:18080',//
      16 => '47.99.114.186:15986',
      17 => '36.248.214.42:1080',
      18 => '115.231.181.40:8128',//
      19 => '112.111.13.253:7890',
    ];

sort($b);
print_r($b);
