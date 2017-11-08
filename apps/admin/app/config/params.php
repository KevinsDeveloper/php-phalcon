<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 11:34
 */

$uploadDomain = ['http://res.armendao.com', 'http://rest.armendao.com'];

return [
    'upload.url' => $uploadDomain[APP_ENVIRONMENT],
    'login.session' => md5('Ymd') . SAFE_KEY,
    'login.power' => md5(date('Ymd')),

    // 阿里云短信
    'sms.accessKeyId' => 'LTAI8RNjAHfN48Xy',
    'sms.accessKeySecret' => 'G7stdx7PzGMTc5Ol55qIImyrXTblXa',

    'setting.form' => ['text', 'textarea'],

    'colors' => ['default', 'primary', 'info', 'success', 'danger', 'warning'],
];