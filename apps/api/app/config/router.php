<?php

$router = $di->getRouter();

// 自定义router
foreach ($module as $mod => $val) {
    $namespace = str_replace('Module', 'controllers', $val["className"]);
    $router->add('/' . $mod . '/:params', array(
        'namespace' => $namespace,
        'module' => $mod,
        'controller' => 'index',
        'action' => 'index',
        'params' => 1,
    ))->setName($mod);
    $router->add("/{$mod}/:controller", [
        'namespace' => $namespace,
        'module' => $mod,
        'controller' => 1,
        'action' => 'index',
    ]);
    $router->add("/{$mod}/:controller/:action", [
        'namespace' => $namespace,
        'module' => $mod,
        'controller' => 1,
        'action' => 2,
    ]);
}

$router->handle();
