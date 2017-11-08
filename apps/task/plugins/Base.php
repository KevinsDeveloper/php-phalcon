<?php

/**
 * @link      http://www.giantnet.cn/
 * @copyright Copyright (c) 2016
 * @version   Beta 1.0
 * @author    kevin <xuwenhu369@163.com>
 */

class Base
{

    /**
     * @desc 生成唯一字符串
     * @return string
     */
    public static function uniqueGuid()
    {
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $uuid = substr($charid, 0, 8) . substr($charid, 8, 4) . substr($charid, 12, 4) . substr($charid, 16, 4) . substr($charid, 20, 12);
        return $uuid;
    }

    /**
     * 检查输入的是否为手机号
     * @param  $val
     * @return bool true false
     */
    public static function isMobile($val)
    {
        //该表达式可以验证那些不小心把连接符“-”写出“－”的或者下划线“_”的等等
        if (preg_match("/^1[3|4|5|8][0-9]\d{4,8}$/", $val)) {
            return true;
        }

        return false;
    }

    /**
     * 返回model错误信息
     * @param $error
     * @return string
     */
    public static function modelError($error)
    {
        $return = 'Error:';
        if (empty($error)) {
            return $return;
        }
        foreach ($error as $v) {
            $return .= $v . '<br>';
        }

        return $return;
    }

}
