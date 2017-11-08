<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/8/30 18:04
 */

namespace plugins\json;

use Phalcon\Http\Response;

/**
 * Class JResponse
 * @package plugins\json
 */
class JResponse
{
    /**
     * @var null 静态变量保存全局实例
     */
    private static $_instance = null;

    /**
     * @var response
     */
    private $response;

    /**
     * @var int 状态
     */
    public $statusCode = 200;
    /**
     * @var string 提示语
     */
    public $statusMessage = 'success';

    /**
     * @var array 内容
     */
    public $jsonContent = [];

    /**
     * JResponse constructor.
     */
    private function __construct()
    {
    }

    /**
     * private __clone
     */
    private function __clone()
    {
    }

    /**
     * @return JResponse|null
     */
    public static function app()
    {
        if (is_null(self::$_instance) || isset (self::$_instance)) {
            self::$_instance = new self ();
            self::$_instance->response = new Response();
        }
        return self::$_instance;
    }

    /**
     * send array to json
     * @param $result 返回数据
     * @param int $status 返回状态
     * @return Response
     */
    public function send($result, $status = 200)
    {
        $this->jsonContent = $result;
        $this->response->setStatusCode($status);
        $this->response->setJsonContent($this->jsonContent, JSON_UNESCAPED_UNICODE);

        $this->response->send();
        return $status == 200 ? true : false;
    }

    /**
     * 返回json data
     * @param $data 数据
     * @param string $ret 状态
     * @param string $msg 提示语
     * @return Response
     */
    public function success($data, $ret = '', $msg = '')
    {
        $ret = !empty($ret) ? $ret : $this->statusCode;
        $msg = !empty($msg) ? $msg : $this->statusMessage;

        $this->jsonContent = [
            'ret' => $ret,
            'data' => (array)$data,
            'msg' => $msg
        ];

        return $this->send($this->jsonContent, $ret);
    }

    /**
     * 返回json error
     * @param $ret 状态
     * @param $msg 提示语
     * @param int $status response status
     * @return Response
     */
    public function error($ret, $msg, $status = 500)
    {
        $this->jsonContent = [
            'ret' => $ret,
            'msg' => $msg
        ];

        return $this->send($this->jsonContent, $status);
        // exit($status);
    }

    /**
     * 返回json error
     * @param $ret 状态
     * @param $msg 提示语
     * @param int $status response status
     * @return Response
     */
    public function end($ret, $msg, $status = 500)
    {
        $this->jsonContent = [
            'ret' => $ret,
            'msg' => $msg
        ];

        $this->send($this->jsonContent, $status);
        exit($status);
    }

    /**
     * @param $ret
     * @param $msg
     * @throws \Exception
     */
    public function exception($ret, $msg)
    {
        throw new \Exception($msg, $ret);
    }
}