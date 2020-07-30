<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use EquivRoute\Router;
use Topdb\Table;
use NewUI\Engine;

global $_CONFIG, $template, $_VAR;
define('ROOT', dirname(__DIR__));
defined('ROOT_DIR') or define('ROOT_DIR', 'I:/env');

require ROOT . '/vendor/autoload.php';
$_CONFIG = include ROOT . '/app/config.php';
$route = include ROOT . '/app/route.php';

// 依赖函数
func($_CONFIG['func']['config'], $_CONFIG['func']['load']);

$template = new Engine(ROOT . '/app/template');
$router = new Router($route['name'], $route['routes'], $route['options']);
$db_contect = $_CONFIG['database_contect'] ?? 'database';
$db_config = $_CONFIG[$db_contect];
Table::init($db_config, 'wuding/topdb');
#print_r(\Ext\PDO::config($_CONFIG['db']));
$template->setCallback($_CONFIG['template']['output_callback']);

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_CONFIG['uri_custom'] ? : $_SERVER['REQUEST_URI'];
$routeInfo = $router->dispatch($httpMethod, $uri, $route['status']);

include ROOT . '/example/' . $_CONFIG['example'] . '.php';
