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
echo("App: " . print_r($app, true));

$logger = new Logger\FileLogger($app);



$router = new Router\ApiRouter($config->get('API_NAMESPACE'));

$app->router->route($_GET['__dy_path']);

var_dump($app);
