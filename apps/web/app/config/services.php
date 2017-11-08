<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Http\Response;
use Phalcon\Http\Response\Cookies;
use Phalcon\Mvc\Router;
use Phalcon\Crypt;
use Phalcon\Security;

/**
 * debug
 */
if (APP_DEBUG) {
    $debug = new \Phalcon\Debug();
    $debug->listen();
}

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ]);

            return $volt;
        },
        '.phtml' => PhpEngine::class

    ]);

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    return $connection;
});

/**
 * redis connection
 */
$di->setShared('redis', function () {
    $config = $this->getConfig();

    $options = [
        'host' => $config->redis->host,
        'port' => $config->redis->port,
        'database' => $config->redis->database,
    ];

    $connection = new \plugins\redis\RedisClient($options);

    return $connection->client();
});

/**
 * Register the crypt
 */
$di->set('crypt', function () {
    $crypt = new Crypt();
    // Set a global encryption key
    $crypt->setKey(CRYPT_KEY);
    return $crypt;
}, true);

/**
 * Register the security
 */
$di->set('security', function () {
    $security = new Security();

    // Set the password hashing factor to 12 rounds
    $security->setWorkFactor(12);

    return $security;
}, true);

/**
 * Registering a logger
 */
$di->setShared('logger', function () {
    $config = $this->getConfig();
    return new LoggerFile($config->application->logDir . date('YmdH') . '.log');
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});