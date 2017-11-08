<?php
/**
 * @link      http://www.giantnet.cn/
 * @copyright Copyright (c) 2016
 * @version   Beta 1.0
 * @author    kevin <xuwenhu369@163.com>
 */

namespace app\modules\settings\models;

/**
 * Class Tree
 * @package lib\library
 */
class Tree
{
    /**
     * @var int
     */
    private $rank = 0;

    /**
     * @var array
     */
    private $arr = [];

    /**
     * @var string
     */
    public $nbsp = '&nbsp;&nbsp;└&nbsp;';

    /**
     * @desc
     * @var string
     */
    public $repeat = '-';

    /**
     * @var null
     */
    public $tmplate = null;

    /**
     * @var int
     */
    public $selected = 0;

    /**
     * Tree constructor.
     *
     * @param $di
     */
    public function __construct($di)
    {
        $this->_di = $di;
    }

    /**
     * @param array $arr
     */
    public function init($arr = [])
    {
        $this->arr = $arr;
    }

    /**
     * @param int $pid
     *
     * @return string
     */
    public function getShiftTree($pid = 0)
    {
        $returnData = "";
        if (empty($this->arr)) {
            return $returnData;
        }
        foreach ($this->arr as $ar) {
            if ($ar['pid'] == $pid) {
                $returnData .= $this->viewTmplate($ar);
                $returnData .= $this->getShiftTree($ar['id']);
            }
        }

        return $returnData;
    }

    /**
     * @desc
     * @access public
     * @param  string $field
     * @param  int $pid
     * @return array
     */
    public function setNameTree($field, $pid = 0)
    {
        $returnData = [];
        if (empty($this->arr)) {
            return $returnData;
        }
        foreach ($this->arr as $k => $v) {
            if ($v['pid'] == $pid) {
                if ($v['rank'] > 0) $v[$field] = $this->nbsp . str_repeat($this->repeat, $v['rank'] - 1) . $v[$field];
                $returnData[] = $v;
                $tdata = $this->setNameTree($field, $v['id']);
                if ($tdata) {
                    //$returnData[] = array_values($tdata);
                    $returnData = array_merge($returnData, array_values($tdata));
                }
            }
        }
        return $returnData;
    }

    /**
     * 返回模板数据
     *
     * @param array $arr
     *
     * @return string
     */
    private function viewTmplate($arr = [])
    {
        $tmplate = $this->tmplate;
        $arr['rank'] = isset($arr['rank']) && $arr['rank'] > 0 ? $arr['rank'] : '';
        if (!empty($arr['rank'])) {
            $tmplate = str_replace("%rank", str_repeat($this->nbsp, $arr['rank']), $tmplate);
        }
        $tmplate = str_replace("%selected", ($arr['id'] == $this->selected ? 'selected' : ""), $tmplate);
        foreach ($arr as $k => $v) {
            if (!is_array($v)) {
                $tmplate = str_replace("%" . $k, $v, $tmplate);
            }
        }
        return $tmplate;
    }
}