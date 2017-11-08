<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 10:44
 */

namespace plugins\redis;

use plugins\json\JResponse as JsonResponse;

/**
 * Class Frequency
 * @package plugins\redis
 */
class Frequency
{
    /**
     * @var string redis keys
     */
    private $_keys = 'api:requestcount:';

    /**
     * @var integer max count
     */
    private $_max = 10000;

    /**
     * @var dispatcher
     */
    private $_dispatcher;

    /**
     * @var redis
     */
    private $_redis;

    /**
     * Frequency constructor.
     * @param $dispatcher
     */
    public function __construct($dispatcher, $di)
    {
        $this->_dispatcher = $dispatcher;
        $this->_keys = $this->_keys . md5($dispatcher->getModuleName() . $dispatcher->getControllerName() . $dispatcher->getActionName());
        $this->_redis = $di->get('redis');
    }

    /**
     * set key
     * @param $key
     * @return string
     */
    public function setKey($key)
    {
        $this->_keys = $key;
        return $this->_keys;
    }

    /**
     * validate keys
     * @return int
     */
    public function validate()
    {
        // 如果存在键
        $exists = $this->_redis->exists($this->_keys);
        if ($exists) {
            $count = $this->_redis->get($this->_keys);
            if ($count >= $this->_max) {
                return JsonResponse::app()->error(500, 'Your access frequency is too high');
            }
            // 写入
            $this->_redis->incr($this->_keys);
        } else {
            // 写入并设置时间
            $this->_redis->incr($this->_keys);
            $this->_redis->expire($this->_keys);
        }

        return $this->_redis->get($this->_keys);
    }
}