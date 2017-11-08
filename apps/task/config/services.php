<?php

use Phalcon\Cli\Console as ConsoleApp;
use Phalcon\Di\FactoryDefault\Cli as CliDI;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include __DIR__ . "/config.php";
});

// Create a console application
$console = new ConsoleApp();
$console->setDI($di);
/**
 * di setShared console
 */
$di->setShared("console", $console);


/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->mysql->adapter;
    $params = [
        'host' => $config->mysql->host,
        'username' => $config->mysql->username,
        'password' => $config->mysql->password,
        'dbname' => $config->mysql->dbname,
        'charset' => $config->mysql->charset,
    ];

    if ($config->mysql->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);
    return $connection;
});