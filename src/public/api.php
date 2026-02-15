<?php

require_once '../initialize.php';
require_once BASE_PATH . 'vendor/autoload.php';

use Dysback\Ogo\Logger as Logger;
use Dysback\Ogo\Router as Router;
use Dysback\Ogo\App as App;
use Dysback\Ogo\Config as Config;


$app = App::initialize([
    BASE_PATH . 'configs/config.' . ENVIRONMENT . '.php',
]);
$config = new Config\Config($app);
$app->setConfig($config);
die("App: " . print_r($app, true));


$config = Config\Config::getInstance();
$config->loadFromPhpFile(BASE_PATH . 'configs/config.' . ENVIRONMENT . '.php');

$logger = Logger\FileLogger::getInstance(
    BASE_PATH . 'logs/api.log',
    $config->get('APPLICATION_NAME'),
    $config->get('MCT_LOG_LEVEL')
);

$router = new Router\ApiRouter($config->get('API_NAMESPACE'));

$app->router->route($_GET['__dy_path']);

var_dump($app);
