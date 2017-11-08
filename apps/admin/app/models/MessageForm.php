<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    Kevin
 * @time      2017/9/25 0025 下午 4:23
 */

namespace app\models;

use Phalcon\Filter;

/**
 * Class MessageForm
 * @package app\models
 */
class MessageForm extends \Phalcon\Mvc\Model
{
    /**
     * @desc
     * @var object
     */
    private $di;

    /**
     * @desc
     * @var object
     */
    private $config;

    /**
     * @desc
     * @var object
     */
    private $redis;

    /**
     * @desc
     * @var bool
     */
    private $sms = false;

    /**
     * @desc
     * @access public
     * @return array
     */
    public function initialize()
    {
        $this->init();
    }

    /**
     * AgentLoginForm constructor.
     */
    public function init()
    {
        $this->di = $this->getDI();
        $this->config = $this->di->get('config');
        $this->redis = $this->di->get('redis');
    }

    /**
     * @desc   短信通道
     * @access public
     * @return array
     */
    public function sms()
    {
        return new \plugins\sms\Aliyun($this->config->params['sms.accessKeyId'], $this->config->params['sms.accessKeySecret']);
    }

    /**
     * 发送校验
     * @param $phone
     * @return \Phalcon\Http\Response
     */
    public function check($redisKey, $phone)
    {
        $time = time();
        // 判断是否频繁发送
        /*if ($this->redis->HEXISTS($redisKey, $phone) == 1)
        {
            $val = $this->redis->HGET($redisKey, $phone);
            if ($time - $val['time'] < 30) {
                return $this->errors('您发送短信过于频繁，歇会吧！');
            }
        }*/
        // 是否写入redis
        if (!$this->redis->HMSET($redisKey, [$phone => ['time' => $time]])) {
            return $this->errors("发送失败");
        }
    }


    /**
     * @desc   开通代理短信通知
     * @access public
     * @param  string $phone 手机号
     * @param  sting $account 账号
     * @param  stiing $pwd 密码
     * @return array
     */
    public function openAgent($phone, $realname, $account, $pwd)
    {
        $redisKey = 'staff::openAgent';
        $check = $this->check($redisKey, $phone);
        if ($check['status']) {
            return $check;
        }
        $send = $this->sms()->sendSms('SMS_100240028', $phone, ['area' => (string)$realname, 'username' => (string)$account, 'password' => (string)$pwd]);
        if ($send->Code == 'OK') {
            return $this->success();
        } else {
            return $this->errors($send->Message);
        }
    }

    /**
     * 错误
     * @param $msg
     * @return
     */
    private function errors($msg)
    {
        return ['status' => 1, 'msg' => $msg];
    }

    /**
     * @desc   成功
     * @access public
     * @return array
     */
    private function success()
    {
        return ['status' => 0, 'msg' => ''];
    }
}