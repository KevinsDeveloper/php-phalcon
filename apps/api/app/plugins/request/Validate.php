<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 10:44
 */

namespace plugins\request;

use plugins\json\JResponse as JsonResponse;

/**
 * Class validate
 * @package plugins\request
 */
class Validate
{
    /**
     * @var $requestData
     */
    private $requestData;

    /**
     * __construct
     * @param array $requestParams
     */
    public function __construct($requestParams)
    {
        $this->requestData = $requestParams;
    }

    /**
     * requestParams valiade
     * @param  $field 字段
     * @param  string $type 类型
     * @return array
     */
    public function requestParams($field, $type = 'string')
    {
        if (!is_array($field)) {
            $field = (array)$field;
        }

        $returnData = [];
        foreach ($field as $value) {
            if (!in_array($value, array_keys($this->requestData))) {
                return JsonResponse::app()->end(500, "{$value} params not empty");
            }
            $returnData[$value] = $this->validateField($type, $value);
        }
        return $returnData;
    }

    /**
     * 校验
     * @param $type     类型
     * @param $field    字段
     * @return mixed
     */
    public function validateField($type, $field)
    {
        $function = "check" . ucfirst($type);

        if (!in_array($function, get_class_methods(__CLASS__))) {
            return JsonResponse::app()->end(500, "{$function} error");
        }
        if (!$this->$function($this->requestData[$field])) {
            return JsonResponse::app()->end(500, "{$field} error");
        }

        return $this->requestData[$field];
    }

    /**
     * @param $value 值
     * @return bool
     */
    private function checkInt($value)
    {
        return is_integer($value);
    }

    /**
     * @param $value 值
     * @return bool
     */
    private function checkString($value)
    {
        return is_string($value);
    }
}