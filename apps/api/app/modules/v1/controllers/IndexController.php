<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 8:57
 */

namespace app\modules\v1\controllers;

use plugins\json\JController as JsonController;
use plugins\json\JResponse as JsonResponse;

/**
 * @desc v1模块首页
 * Class IndexController
 * @package app\modules\v1\controllers
 */
class IndexController extends JsonController
{
    /**
     * @desc index
     */
    public function indexAction()
    {
        $text = date('YmdHis');
        $encryptBase64 = $this->crypt->encryptBase64($this->crypt->encrypt($text), SAFE_KEY);
        $decryptBase64 = $this->crypt->decrypt($this->crypt->decryptBase64($encryptBase64, SAFE_KEY));

        return ([
            "title" => "v1 success",
            "version" => "1.0.0",
            "request" => $this->requestParams,
            "encrypt" => $encryptBase64,
            "decrypt" => $decryptBase64,
            "time" => time(),
        ]);
    }

    public function listsAction()
    {
        return JsonResponse::app()->error(500, 'request error');
    }

}