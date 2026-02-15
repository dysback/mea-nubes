<?php

require_once '../initialize.php';
require_once BASE_PATH . 'vendor/autoload.php';

use Dysback\Ogo\Logger as Logger;
use Dysback\Ogo\Router as Router;
use Dysback\Ogo\App as App;
use Dysback\Ogo\Config as Config;

$app = App::initialize(
    [BASE_PATH . 'configs/config.' . ENVIRONMENT . '.php'],
    BASE_PATH,
    ENVIRONMENT,
);

$config = new Config\Config($app);
$app->setConfig($config);

$logger = new Logger\FileLogger($app);
$app->setLogger($logger);
$logger->log('Logger working', Logger\LogLevel::DEBUG, 'APIPI');


$router = new Router\ApiRouter($app);
$app->setRouter($router);
$app->router->route($_GET['__dy_path']);

//echo("App: " . print_r($app, true));
