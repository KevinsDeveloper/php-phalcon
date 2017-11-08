<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 8:57
 */

use Phalcon\Mvc\Controller;

/**
 * Class BaseController
 */
class BaseController extends Controller
{
	/**
     * controller onConstruct
     */
    public function onConstruct()
    {
        //$this->response->setContentType("application/json", "UTF-8");
    }

    /**
     * controller initialize
     */
    public function initialize()
    {
    }

    /**
     * beforeExecuteRoute
     * @param $dispatcher
     * @return bool
     */
    public function beforeExecuteRoute($dispatcher)
    {
        return true;
    }

    /**
     * afterExecuteRoute
     * @param $dispatcher
     * @return bool
     */
    public function afterExecuteRoute($dispatcher)
    {
        return true;
    }
}