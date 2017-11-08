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
 * Class RedisClient
 * @package plugins\redis
 */
class RedisClient
{
    /**
     * @var bool redisClient
     */
    private $redisClient = false;

    /**
     * @var array redis options
     */
    private $options = [];

    /**
     * RedisClient constructor.
     * @param $options
     */
    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * Client Redis
     * @param  boolean $pconnect 是否长连接
     * @return object
     */
    public function client($pconnect = true)
    {
        if ($this->redisClient) {
            return $this->redisClient;
        }

        if (!in_array('redis', get_loaded_extensions())) {
            return JsonResponse::app()->exception(500, 'Redis extension isn\'t installed.');
        }

        try {
            $redis = new \Redis();
            if ($pconnect) {
                $redis->pconnect($this->options['host'], $this->options['port'], 0, "x");
            } else {
                $redis->connect($this->options['host'], $this->options['port'], 0, "x");
            }
            $redis->select($this->options['database']);
            $redis->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_PHP);
            
            $this->redisClient = $redis;
            return $this->redisClient;

        } catch (\Exception $e) {
            return JsonResponse::app()->exception($e->getCode(), $e->getMessage());
        }
    }

    /**
     * select db
     * @param $db
     * @return bool
     */
    public function select($db)
    {
        if (!$this->redisClient) {
            return false;
        }
        $this->redisClient->select($db);
        return $this->redisClient;
    }
}