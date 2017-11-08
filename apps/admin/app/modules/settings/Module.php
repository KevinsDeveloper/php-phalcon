<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 8:57
 */

namespace app\modules\settings;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

/**
 * Class Module
 * @package app\modules\settings
 */
class Module implements ModuleDefinitionInterface {

	/**
	 * Registers an autoloader related to the module
	 * @param DiInterface|null $di
	 */
	public function registerAutoloaders(DiInterface $di = null) {
		$loader = new Loader();

		$loader->registerNamespaces([
			'app\modules\settings\models' => __DIR__ . '/models/',
		]);

		$loader->register();
	}

	/**
	 * Registers services related to the module
	 * @param DiInterface $di
	 */
	public function registerServices(DiInterface $di) {
		/**
		 * Setting up the view component
		 */
		$view = $di->get('view');

		$view->setMainView("../index");
		$view->setViewsDir($di->get('config')->application->viewsDir . $di->get('router')->getModuleName());

		$di->set('view', $view);
	}

}
