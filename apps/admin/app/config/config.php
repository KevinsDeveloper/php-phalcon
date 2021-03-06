<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');
defined('UPLOAD_PATH') || define('UPLOAD_PATH', APPS_PATH . '/uploads/');

return new \Phalcon\Config([
    'mysql' => include APPS_PATH . "/config/mysql.php",
    'redis' => include APPS_PATH . '/config/redis.php',
    'params' => include APP_PATH . '/config/params.php',
    'application' => [
        'appDir' => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir' => APP_PATH . '/models/',
        'migrationsDir' => APP_PATH . '/migrations/',
        'viewsDir' => APP_PATH . '/views/',
        'pluginsDir' => APP_PATH . '/plugins/',
        'libraryDir' => APP_PATH . '/library/',
        'messageDir' => APP_PATH . '/messages/',
        'cacheDir' => BASE_PATH . '/cache/',
        'logDir' => BASE_PATH . '/cache/log/',
        'vendorDir' => APPS_PATH . '/vendor/',

        // This allows the baseUri to be understand project paths that are not in the root directory
        // of the webpspace.  This will break if the public/index.php entry point is moved or
        // possibly if the web server rewrite rules are changed. This can also be set to a static path.
        'baseUri' => '/',
        'environment' => APP_ENVIRONMENT,
    ]
]);
