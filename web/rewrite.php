<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use EquivRoute\Router;
use Topdb\Table;
use NewUI\Engine;
use model\Glob;
use Ext\X\PhpRedis;

global $template, $_VAR;
define('ROOT', dirname(__DIR__));
defined('ROOT_DIR') or define('ROOT_DIR', 'I:/env');

require ROOT . '/vendor/autoload.php';
Glob::diff('REWRITE_AUTOLOAD');
Glob::$conf = include ROOT . '/app/config.php';
$route = include ROOT . '/app/route.php';

// 依赖函数
func(Glob::conf('func.config'), Glob::conf('func.load'));
#Glob::diff('REWRITE_FUNC');
$template = new Engine(ROOT . '/app/template');
$router = new Router($route['name'], $route['routes'], $route['options']);
$db_config = Glob::cnf('database_contect', 'database');
Table::init($db_config, 'wuding/topdb');
#print_r(\Ext\PDO::config($_CONFIG['db']));
$template->setCallback(Glob::conf('template.output_callback'));
#Glob::diff('REWRITE_NEW_OBJ');

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = Glob::conf('uri_custom') ?: $_SERVER['REQUEST_URI'];
$routeInfo = $router->dispatch($httpMethod, $uri, $route['status']);
#Glob::diff('REWRITE_ROUTE');

// 准备工作
PhpRedis::conn(Glob::conf('redis.host'), Glob::conf('redis.port'), 0, null, 0, 0, ['auth' => Glob::conf('redis.auth')]);
PhpRedis::db(Glob::conf('redis.dbindex'));
Glob::diff('REDIS_CONN');
include ROOT . '/example/' . Glob::conf('example') . '.php';
