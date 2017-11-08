<?php

$loader = new \Phalcon\Loader();

/**
 * Get config service for use in inline setup below
 */
$config = $di->getConfig();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->pluginsDir,
        APPS_PATH . 'vendor/models',
    ]
)->registerNamespaces([
    'app' => APP_PATH,
    'plugins' => $config->application->pluginsDir
]);
$loader->register();