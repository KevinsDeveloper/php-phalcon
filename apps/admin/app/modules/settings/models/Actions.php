<?php
/**
 * @link      http://www.giantnet.cn/
 * @copyright Copyright (c) 2016
 * @version   Beta 1.0
 * @author    kevin <xuwenhu369@163.com>
 */

namespace app\modules\settings\models;

/**
 * Class Actions
 * @package app\modules\sys\models
 */
class Actions
{

    /**
     * @var array
     */
    private $arr = [];

    /**
     * @var string
     */
    public $nbsp = '&nbsp;&nbsp;┣&nbsp;';

    /**
     * @var null
     */
    public $tmplate = null;

    /**
     * @var null
     */
    public $labelTemplate = null;

    /**
     * @var array
     */
    public $selected = [];

    /**
     * @var array
     */
    public $power;

    /**
     * @param array $arr
     *
     * @return bool
     */
    public function init($arr = [])
    {
        if (empty($arr)) {
            return false;
        }
        foreach ($arr as $field => $value) {
            $this->$field = $value;
        }
        $this->power = $this->getPower();
    }

    /**
     * 获取所有的动作
     * @param  integer $pid 父级ID
     * @return string
     */
    public function getActions($pid = 0)
    {
        $returnData = "";
        if (empty($this->arr)) {
            return $returnData;
        }

        foreach ($this->arr as $ar) {
            if ($ar['pid'] == $pid) {
                $returnData .= $this->viewTmplate($ar);
                $returnData .= $this->getActions($ar['id']);
            }
        }
        return $returnData;

    }

    /**
     * @param array $arr
     * @return string
     */
    private function labelViewTemplate($arr = [])
    {

        $label = "";
        if ($arr['pid'] == 0) {
            return $label;
        }
        $modules = include APP_PATH . "/config/module.php";
        if (empty($modules) || !isset($modules[$arr['module']])) {
            return $label;
        }

        $module = $modules[$arr['module']];
        $className = ucfirst($arr['controller']) . "Controller";
        $controller = $module['controllerDir'] . '/' . $className . ".php";
        $namespace = sprintf("\app\modules\%s\controllers\%s", $arr['module'], $className);
        if (!is_file($controller)) {
            return $label;
        }


        $classObject = new $namespace();
        $methods = get_class_methods($classObject);

        foreach ($methods as $method) {
            if (stripos($method, "Action") != true) {
                continue;
            }
            $name = self::getMethodDesc($classObject, $method);
            $method = str_replace("Action", "", lcfirst($method));

            $val = '/' . $arr['module'] . "/" . $arr['controller'] . "/" . $method;

            $labeltmplate = $this->labelTemplate;
            $checked = in_array($val, $this->power['actions']) ? "checked" : "";

            $labeltmplate = str_replace("%checked", $checked, $labeltmplate);
            $labeltmplate = str_replace("%value", $val, $labeltmplate);
            $labeltmplate = str_replace("%title", $name, $labeltmplate);
            $labeltmplate = str_replace("%menu", $arr['id'], $labeltmplate);
            $label .= $labeltmplate;
        }

        return $label;
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
        $checked = in_array($arr['id'], $this->power['menus']) ? "checked" : "";
        $tmplate = str_replace("%checked", $checked, $tmplate);
        foreach ($arr as $k => $v) {
            if (!is_array($v) && $k != 'pid') {
                $tmplate = str_replace("%" . $k, $v, $tmplate);
            }
        }
        if ($arr['pid']) {
            $tmplate = str_replace("%data-pid", $arr['pid'], $tmplate);
            $tmplate = str_replace('%pid', $arr['pid'] . '_son', $tmplate);
            $tmplate = str_replace('%top', '', $tmplate);
        } else {
            $tmplate = str_replace("%data-pid", $arr['id'], $tmplate);
            $tmplate = str_replace('%pid', $arr['id'], $tmplate);
            $tmplate = str_replace('%top', 'top', $tmplate);
        }
        $tmplate = str_replace("%label", $this->labelViewTemplate($arr), $tmplate);

        return $tmplate;
    }

    /**
     * 获取权限
     * @return array
     */
    private function getPower()
    {
        if (empty($this->power)) {
            return [];
        }
        $menus = $actions = [];
        foreach ($this->power as $val) {
            if ($val->type == 0) {
                $menus[] = $val->menu_id;
            }
            if ($val->type == 1) {
                $actions[] = $val->url;
            }
        }

        return ['menus' => $menus, 'actions' => $actions];
    }

    /**
     * @desc 获取注释信息
     * @param $class
     * @param $className
     *
     * @return string
     */
    private function getClassDesc($class, $className)
    {
        $reflection = new \ReflectionClass($class);
        $docComment = $reflection->getDocComment();
        preg_match_all('/@desc(.*?)\n/', $docComment, $flag);

        return !empty($flag[1]) ? trim($flag[1][0], ' ') : $className;
    }

    /**
     * @desc 获取注释信息
     *
     * @param        $class
     * @param string $action
     *
     * @return string
     */
    private function getMethodDesc($class, $action = "")
    {
        $reflection = new \ReflectionMethod($class, $action);
        $docComment = $reflection->getDocComment();
        preg_match_all('/@desc ' . $action . '(.*?)\n/', $docComment, $flag);
        if (empty($flag[1])) {
            preg_match_all('/@desc (.*?)\n/', $docComment, $flag);
        }

        return !empty($flag[1]) ? trim($flag[1][0], ' ') : $action;
    }
}