<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 8:57
 */

use Phalcon\Mvc\Controller;
use plugins\json\JResponse as JsonResponse;

/**
 * 默认访问
 * Class IndexController
 */
class IndexController extends Controller
{
    /**
     * 首页
     * @return \Phalcon\Http\Response
     */
    public function indexAction()
    {
        $resultData = [
            "title" => "request success",
            "version" => "1.0.0",
            "redis" => $this->redis->get('b'),
            "time" => time(),
        ];

        $rsa = new \plugins\rsa\RSA();
        $resultData['encrypt'] = $rsa->encrypt($resultData);

        return JsonResponse::app()->success($resultData);
    }

    /**
     * @param $status
     * @param $messages
     * @return \Phalcon\Http\Response
     */
    public function errorAction($status, $messages)
    {
        return JsonResponse::app()->error($status, $messages);
    }
}