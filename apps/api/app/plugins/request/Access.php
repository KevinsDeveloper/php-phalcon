<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 10:44
 */

namespace plugins\request;

use plugins\json\JResponse as JsonResponse;

// +----------------------------------------------------------------------
// | token 参数校验方式：
// | md5(请求参数按照ASCII码顺序用&拼接&API密钥)
// | 如： md5(a=1&b=2&c=3&API_KEY)
// +----------------------------------------------------------------------

/**
 * Class Access
 * @package plugins\request
 */
class Access
{
    /**
     * @var Access response
     */
    private $request;

    /**
     * @var string token name
     */
    private $token_params = 'token';

    /**
     * @var string time name
     */
    private $time_params = 'time';

    /**
     * @var integer time out secend
     */
    private $time_out = 60;

    /**
     * @var Access params
     */
    private $requestParams;

    /**
     * RequestAccess constructor.
     * @param $request
     */
    public function __construct($di, $request)
    {
        $this->request = $request;
        $this->requestParams = $this->getParams();
        $this->time_out = APP_DEBUG ? 36000 : 60;
    }

    /**
     * get access token
     * @param string $default
     * @return mixed|string
     */
    public function getToken($default = '')
    {
        return isset($this->requestParams[$this->token_params]) ? (string)$this->requestParams[$this->token_params] : $default;
    }

    /**
     * get access time
     * @param int $default
     * @return int
     */
    public function getTime($default = 0)
    {
        return isset($this->requestParams[$this->time_params]) ? intval($this->requestParams[$this->time_params]) : $default;
    }

    /**
     * validate token
     * @return bool
     */
    public function validate()
    {
        if (APP_DEBUG) {
            return true;
        }

        // request token
        $token = $this->getToken();
        if (empty($token)) {
            return JsonResponse::app()->error(500, "The token params cannot be null");
        }

        // request time
        $time = $this->getTime();
        if ($time == 0) {
            return JsonResponse::app()->error(500, "The time params cannot be null");
        }
        if (time() - $time > $this->time_out) {
            return JsonResponse::app()->error(504, "request timeout");
        }

        // 处理request params
        unset($this->requestParams[$this->token_params]);
        if (isset($this->requestParams['_url'])) {
            unset($this->requestParams['_url']);
        }

        ksort($this->requestParams);
        $md5 = md5($this->httpBuildParams() . '&' . API_KEY);

        // 校验token是否一致
        if (strtolower($md5) != strtolower($token)) {
            // debug模式返回
            if (APP_DEBUG) {
                return JsonResponse::app()->success([
                    'token' => strtolower($md5),
                    'params' => $this->httpBuildParams() . '&' . API_KEY],
                    500,
                    "The token params is error."
                );
            }
            return JsonResponse::app()->error(500, "The token params is error.");
        }
        return true;
    }

    /**
     * get request params
     * @return array|bool|string
     */
    public function getParams()
    {
        $method = $this->request->getMethod();

        switch ($method) {
            case 'GET':
                return (array)$this->request->get();
                break;

            case 'POST':
                return (array)$this->request->getPost();
                break;

            case 'PUT':
                return file_get_contents('php://input');
                break;

            default:
                return [];
                break;
        }
    }

    /**
     * @param string $default
     * @return string
     */
    private function httpBuildParams($default = '')
    {
        if (empty($this->requestParams)) {
            return $default;
        }

        foreach ($this->requestParams as $key => $val) {
            $default .= $key . '=' . $val . '&';
        }
        return rtrim($default, "&");
    }
}