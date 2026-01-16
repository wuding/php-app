<?php

error_reporting(E_ALL);

function check_ip()
{
    $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? null;
    $addr = $_SERVER['REMOTE_ADDR'] ?? null;
    $pattern = "#^(en|ru)#i";
    $subject = trim($lang);
    $patter = "#^(14|103|113|123|128|138|168|177|179|181|185|186|187|190|191|192|200|201|202|37|45)#";
    $patte = "#^123\.(\d+)#";
    if (preg_match($pattern, $subject, $matches)) {
        if (preg_match($patter, $addr, $match)) {
            http_response_code(403);
            die;
        } elseif (preg_match($patte, $addr, $match)) {
            $num = (int) $match[1];
            if (19 < $num && 29 > $num) {
                http_response_code(403);
                die;
            }
            // var_dump([$num, $patte, $addr, $match]);

        }
    }
}

check_ip();


$router = require 'router.php';
return $router;
