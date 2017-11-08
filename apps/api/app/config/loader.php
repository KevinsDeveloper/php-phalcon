<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->libraryDir,
        $config->application->pluginsDir,
    ]
// )->registerFiles([]
)->registerNamespaces([
    'app' => APP_PATH,
    'vendor' => APPS_PATH . 'vendor',
    'plugins' => $config->application->pluginsDir,
])->register();