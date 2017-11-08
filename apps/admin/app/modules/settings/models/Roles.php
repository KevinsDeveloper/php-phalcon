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
 * Class Roles
 * @package app\modules\settings\models
 */
class Roles
{

    /**
     * findRolesByPid
     * @param $role_id
     * @return array
     */
    public static function findRolesByPid($role_id)
    {
        $result = [];
        if ($role_id == 1) $result[0] = '==顶级角色==';
        $where = $role_id > 1 ? ['conditions' => 'pid=?0', 'bind' => [$role_id]] : '';
        $find = \DbAuthRole::find($where);
        if (empty($find)) {
            return $result;
        }
        $treeClass = new \app\modules\settings\models\Tree(Di::getDefault());
        $treeClass->init($find->toArray());
        $find = $treeClass->setNameTree('role_name');
        foreach ($find as $val) {
            $result[$val['id']] = $val['role_name'];
        }
        return $result;
    }

    /**
     * @return array
     */
    public static function getRoles()
    {
        $result = [];
        $find = \DbAuthRole::find();
        if (empty($find)) {
            return $result;
        }
        foreach ($find as $value) {
            $result[$value->id] = $value->role_name;
        }
        return $result;
    }

    /**
     * @desc   查询树等级
     * @access public
     * @param  int $pid
     * @return array
     */
    public static function getRankByPid($pid)
    {
        $rank = 0;
        if ($pid == 0) return $rank;
        $find = \DbAuthRole::findFirst('id=' . $pid);
        if (empty($find)) return $rank;
        return $find->rank + 1;
    }
}