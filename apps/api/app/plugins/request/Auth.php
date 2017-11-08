<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 10:44
 */

namespace plugins\request;

use Phalcon\Crypt;
use plugins\json\JResponse as JsonResponse;

/**
 * Class Auth
 * @package plugins\request
 */
class Auth
{
    /**
     * @var request
     */
    private $request;

    /**
     * @var Access params
     */
    private $requestParams;

    /**
     * @var string auth name
     */
    private $authParams = 'auth';

    /**
     * @var crypt
     */
    private $crypt;

    /**
     * Auth constructor.
     * @param $di
     * @param $requestParams
     */
    public function __construct($di, $requestParams)
    {
        $this->request = $di->get('request');
        $this->crypt = $di->get('crypt');
        $this->requestParams = $requestParams;
    }

    /**
     * get request auth
     * @param  string $default
     * @return string
     */
    public function getAuth($default = '')
    {
        if (isset($this->requestParams[$this->authParams])) {
            // get auth params
            $auth = (string)$this->requestParams[$this->authParams];
            if ($this->request->isGet()) {
                return urldecode($auth);
            }

            return $auth;
        }
        return $default;
    }

    /**
     * get auth
     * @param  string $default
     * @return string|int
     */
    public function get($default = '')
    {
        $auth = $this->getAuth();
        if (empty($auth)) {
            return JsonResponse::app()->exception(500, "The auth params cannot be null");
        }

        return $this->validate($auth, $default);
    }

    /**
     * get isset auth
     * @param  string $default
     * @return string|int
     */
    public function getIsset($default = '')
    {
        $auth = $this->getAuth();
        if (empty($auth)) {
            return $default;
        }

        return $this->validate($auth, $default);
    }

    /**
     * validate auth
     * @param  string $auth
     * @param  string $default
     * @return string|int
     */
    public function validate($auth, $default = '')
    {
        $decryptBase64 = $this->crypt->decryptBase64($auth, SAFE_KEY);
        if (empty($decryptBase64)) {
            return $default;
        }
        $decrypt = $this->crypt->decrypt($decryptBase64);
        if (empty($decrypt)) {
            return $default;
        }

        // 校验auth是否存在
        return is_integer($default) ? intval($decrypt) : (string)$decrypt;
    }
}