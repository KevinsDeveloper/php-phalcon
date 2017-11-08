<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 8:57
 */

namespace plugins\json;

use Phalcon\Mvc\Controller;
use plugins\request\Access as RequestAccess;
use plugins\request\Auth as RequestAuth;
use plugins\json\JResponse as JsonResponse;
use plugins\request\Validate as RequestValidate;
use plugins\redis\Frequency as ApiFrequency;

/**
 * Class JController
 * @package plugins\json
 */
class JController extends Controller
{
    /**
     * @var request params
     */
    protected $requestParams;

    /**
     * @var request validate
     */
    protected $requestValidate;

    /**
     * @var request auth
     */
    protected $requestAuth;

    /**
     * @var string reponse ret
     */
    protected $ret;

    /**
     * @var string reponse msg
     */
    protected $msg;

    /**
     * controller onConstruct
     */
    public function onConstruct()
    {
        $this->response->setContentType("application/json", "UTF-8");
    }

    /**
     * controller initialize
     */
    public function initialize()
    {
        $this->ret = $this->msg = '';
    }

    /**
     * beforeExecuteRoute
     * @param $dispatcher
     * @return bool
     */
    public function beforeExecuteRoute($dispatcher)
    {
        // token验证
        $access = new RequestAccess($dispatcher, $this->request);
        if (!$access->validate()) {
            return false;
        }

        // 访问频率控制
        $frequency = new ApiFrequency($dispatcher, $this->getDI());
        $frequency->validate();

        $this->requestParams = $access->getParams();
        $this->requestAuth = new RequestAuth($this->getDI(), $this->requestParams);
        $this->requestValidate = new RequestValidate($this->requestParams);

        return true;
    }

    /**
     * afterExecuteRoute
     * @param $di
     * @return bool
     */
    public function afterExecuteRoute($di)
    {
        $getReturnedValue = $this->dispatcher->getReturnedValue();
        if (is_array($getReturnedValue)) {
            return JsonResponse::app()->success($getReturnedValue, $this->ret, $this->msg);
        }
        return true;
    }
}