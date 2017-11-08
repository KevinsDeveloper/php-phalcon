<?php

/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    Kevin
 * @time      2017/10/21 0021 上午 11:17
 */

class Base
{

    /**
     * 获取随机数方法
     * @access public
     * @return void
     */
    public static function randomkeys($length = 8)
    {
        $key = "";
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i++) {
            $key .= $pattern{mt_rand(0, 62)};    //生成php随机数
        }

        return $key;
    }

    /**
     * 生成唯一字符串
     * @return string
     */
    public static function uniqueGuid()
    {
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $uuid = substr($charid, 0, 8) . substr($charid, 8, 4) . substr($charid, 12, 4) . substr($charid, 16, 4) . substr($charid, 20, 12);

        return $uuid;
    }

    /**
     * 返回model错误信息
     * @param $error
     * @return string
     */
    public static function modelError($error)
    {
        $return = 'Error：';
        if (empty($error)) {
            return $return;
        }
        foreach ($error as $v) {
            $return .= $v . '<br>';
        }

        return $return;
    }

    /**
     * @desc   生成唯一Guid
     * @access public
     * @return array
     */
    public static function uuid()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand(( double )microtime() * 10000); //optional for php 4.2.0 and up.随便数播种，4.2.0以后不需要了。
            $charid = strtoupper(md5(uniqid(rand(), true))); //根据当前时间（微秒计）生成唯一id.
            $hyphen = chr(45); // "-"
            $uuid = '' . //chr(123)// "{"
                substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);
            //.chr(125);// "}"
            return $uuid;
        }
    }

    /**
     * @return string
     */
    public static function pageurl($params = [])
    {
        $di = \Phalcon\DI::getDefault();
        $request = $di->get('request')->get();
        if (isset($request['_url'])) {
            unset($request['_url']);
        }
        if (count($params) > 0) {
            foreach ($params as $key => $value) {
                if (isset($request[$key])) unset($request[$key]);
                $request[$key] = $value;
            }
        }
        return $request;
    }
}
