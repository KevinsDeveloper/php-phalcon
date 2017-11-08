<?php

$router = $di->getRouter();

// $router->add("/:controller/:action", ['controller' => 1, 'action' => 2]);

// modules router
foreach ($module as $mod => $val) {
    $namespace = str_replace('Module', 'controllers', $val["className"]);
    $router->add('/' . $mod . '/:params', [
        'namespace' => $namespace,
        'module' => $mod,
        'controller' => 'index',
        'action' => 'index',
        'params' => 1
    ])->setName($mod);

    $router->add("/{$mod}/:controller", [
        'namespace' => $namespace,
        'module' => $mod,
        'controller' => 1,
        'action' => 'index'
    ]);

    $router->add("/{$mod}/:controller/:params", [
        'namespace' => $namespace,
        'module' => $mod,
        'controller' => 1,
        'action' => 'index',
        'params' => 2
    ]);

    $router->add("/{$mod}/:controller/:action", [
        'namespace' => $namespace,
        'module' => $mod,
        'controller' => 1,
        'action' => 2
    ]);

    $router->add("/{$mod}/:controller/:action/:params", [
        'namespace' => $namespace,
        'module' => $mod,
        'controller' => 1,
        'action' => 2,
        'params' => 3
    ]);
}

$router->handle();