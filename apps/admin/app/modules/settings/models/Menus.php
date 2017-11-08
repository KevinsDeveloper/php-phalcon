<?php
/**
 * @link      http://www.giantnet.cn/
 * @copyright Copyright (c) 2016
 * @version   Beta 1.0
 * @author    kevin <xuwenhu369@163.com>
 */

namespace app\modules\settings\models;

use \Phalcon\Di;

/**
 * Class Menus
 * @package app\modules\sys\models
 */
class Menus extends \Phalcon\Mvc\Model
{
    /**
     * 查询菜单列表
     * @param string $where
     * @return array
     */
    public static function getMenuList($pid = null)
    {
        $return = [];
        $menuStatus = ['禁用', '可用'];
        $conditions = "1=1";
        if ($pid !== null) {
            $conditions = "pid=" . $pid;
        }
        $menuData = \DbAuthMenu::find(['conditions' => $conditions, 'order' => 'orderby ASC'])->toArray();
        if (empty($menuData)) {
            return $return;
        }
        foreach ($menuData as $menu) {
            $menu['status'] = $menuStatus[$menu['status']];
            $menu['edit'] = Di::getDefault()->get('layers')->open('/settings/menu/edit', '编辑', ['id' => $menu['id']], 600, 500, 'btn btn-primary btn-xs', '<i class="fa fa-pencil"></i>');
            $menu['delete'] = Di::getDefault()->get('layers')->cancel('/settings/menu/delete', $menu['id']);
            $return[$menu['id']] = $menu;
        }

        return $return;
    }

    /**
     * 返回管理员菜单PID
     * @param int $id
     * @return array|void
     */
    public static function getMenuOption($id = 0)
    {
        $menuData = \app\models\DbAdminMenu::find(['status' => 1])->toArray();
        if (empty($menuData)) {
            return [];
        }

        $option = '<option value="0">请选择...</option>';
        foreach ($menuData as $menu) {
            if ($menu['pid'] == 0) {
                $option .= "<option value='{$menu['id']}' " . ($menu['id'] == $id ? 'selected' : '') . ">{$menu['name']}</option>";
                if ($menu['lower_num'] > 0) {
                    $option .= self::pidOption($menuData, $menu['id'], $id);
                }
            }
        }

        return $option;
    }

    /**
     * 获取子级别分类
     * @param array $menuData
     * @param int $pid
     * @param int $id
     *
     * @return string
     */
    private static function pidOption($menuData = [], $pid = 0, $id = 0)
    {
        $option = '';
        foreach ($menuData as $menu) {
            if ($menu['pid'] == $pid) {
                $option .= "<option value='{$menu['id']}' " . ($menu['id'] == $id ? 'selected' : '') . ">" . str_repeat("&nbsp;&nbsp;", $menu['rank']) . "┗ {$menu['name']}</option>";
                if ($menu['lower_num'] > 0) {
                    $option .= self::pidOption($menuData, $menu['id'], $id);
                }
            }
        }

        return $option;
    }
}