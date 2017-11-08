<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 8:57
 */

// +----------------------------------------------------------------------
// | 应用入口文件
// +----------------------------------------------------------------------

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('APPS_PATH', BASE_PATH . '/../../');
define('APP_DEBUG', true);

try {

    /**
     * if exits phalcon extensions
     */
    if (!in_array('phalcon', get_loaded_extensions())) {
        throw new \Exception(
            "Phalcon extension isn't installed, follow these instructions to install it: " .
            "https://docs.phalconphp.com/en/latest/reference/install.html", 500);
    }

    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new \Phalcon\Di\FactoryDefault();

    // Include module
    $module = include APP_PATH . "/config/module.php";

    /**
     * Include bootstrap
     */
    include APPS_PATH . '/vendor/bootstrap.php';

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    // register module
    $application->registerModules($module);

    // echo str_replace(["\n","\r","\t"], '', $application->handle()->getContent());
    $application->handle()->send();

} catch (\Exception $e) {
    header("Content-Type:application/json; charset=utf-8");
    echo json_encode(['ret' => $e->getCode(), 'msg' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
