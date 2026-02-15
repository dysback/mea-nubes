<?php

return [
    'environment' => getenv('MCT_ENVIRONMENT_TYPE'),
    'MCT_DB_HOST' => 'localhost',
    'MCT_DB_PORT' => '3306',
    'MCT_DB_NAME' => 'mct_pilot',
    'MCT_DB_USER' => 'root',
    'MCT_DB_PASSWORD' => 'Sys49152',
    'MCT_LOG_LEVEL' => 'DEBUG',
    'APPLICATION_NAME' => 'NubesMea',
    'API_NAMESPACE' => '\Dysback\NubesMea\Api',
    'LOGGER' => [
        'LOG_LEVEL' => 'DEBUG',
        'LOG_FILE_PATH' => BASE_PATH . 'logs/api_',
    ],

];
