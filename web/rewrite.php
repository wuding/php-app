<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('PRC');

global $_CONFIG, $template;
define('ROOT', dirname(__DIR__));
defined('ROOT_DIR') or define('ROOT_DIR', 'I:/env');

require ROOT . '/vendor/autoload.php';
$_CONFIG = include ROOT . '/app/config.php';

$routeInfo = array();

include ROOT . '/example/' . $_CONFIG['example'] . '.php';
