<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH);

return new \Phalcon\Config([
    'mysql' => include APPS_PATH . "/config/mysql.php",
    'redis' => include APPS_PATH . '/config/redis.php',
    'params' => include APP_PATH . '/config/params.php',
    'application' => [
        'appDir' => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir' => APP_PATH . '/models/',
        'pluginsDir' => APP_PATH . '/plugins/',
        'environment' => APP_ENVIRONMENT,
    ],
]);