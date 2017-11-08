<?php

use Phalcon\Di\FactoryDefault\Cli as CliDI;

// +----------------------------------------------------------------------
// | 应用入口文件
// +----------------------------------------------------------------------

define('BASE_PATH', __DIR__);
define('APP_PATH', BASE_PATH . '/');
define('APPS_PATH', BASE_PATH . '/../../');
// +----------------------------------------------------------------------
// | 是否开启debug
// +----------------------------------------------------------------------
define('APP_DEBUG', true);

// +----------------------------------------------------------------------
// | 环境模式
// | 0=正式环境
// | 1=测试环境
// +----------------------------------------------------------------------
define('APP_ENVIRONMENT', 1);

// Using the CLI factory default services container
$di = new CliDI();

/**
 * Read services
 */

include APP_PATH . '/config/services.php';

/**
 * Include Autoloader
 */
include APP_PATH . '/config/loader.php';

/**
 * Process the console arguments
 */
$arguments = [];

foreach ($argv as $k => $arg) {
    if ($k === 1) {
        $arguments['task'] = $arg;
    } elseif ($k === 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

try {
    // Handle incoming arguments
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    // Do Phalcon related stuff here
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (\Throwable $throwable) {
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(1);
} catch (\Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}