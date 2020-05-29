<?php

$urn = rawurldecode($request_urn);
if (preg_match('/^[\p{Han}]?$/u', $urn)) {
    echo $urn;
    exit;
}

switch (strtolower($request_urn)) {
    case 'temp':
        echo 'test';
        break;

    default:
        include BASE_DIR . '/src/app/template/404.html';
        break;
}
