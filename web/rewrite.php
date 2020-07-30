<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use EquivRoute\Router;
use Topdb\Table;
use NewUI\Engine;
use model\Glob;

global $template, $_VAR;
define('ROOT', dirname(__DIR__));
defined('ROOT_DIR') or define('ROOT_DIR', 'I:/env');

require ROOT . '/vendor/autoload.php';
Glob::$conf = include ROOT . '/app/config.php';
$route = include ROOT . '/app/route.php';

// 依赖函数
func(Glob::conf('func.config'), Glob::conf('func.load'));

$template = new Engine(ROOT . '/app/template');
$router = new Router($route['name'], $route['routes'], $route['options']);
$db_config = Glob::cnf('database_contect', 'database');
Table::init($db_config, 'wuding/topdb');
#print_r(\Ext\PDO::config($_CONFIG['db']));
$template->setCallback(Glob::conf('template.output_callback'));

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = Glob::conf('uri_custom') ?: $_SERVER['REQUEST_URI'];
$routeInfo = $router->dispatch($httpMethod, $uri, $route['status']);

include ROOT . '/example/' . Glob::conf('example') . '.php';
