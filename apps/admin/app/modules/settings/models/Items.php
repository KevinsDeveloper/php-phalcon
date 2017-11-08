<?php
/**
 * @link      http://www.giantnet.cn/
 * @copyright Copyright (c) 2016
 * @version   Beta 1.0
 * @author    kevin <xuwenhu369@163.com>
 */

namespace app\modules\settings\models;

/**
 * Class Items
 * @package app\modules\settings\models
 */
class Items {

	/**
	 * find items by role_id
	 * @param  int $role_id
	 * @return array
	 */
	public static function getAdminItems($role_id) {
		$result = [];
		if (empty($role_id)) {
			return $result;
		}
		// 超级管理员
		if ($role_id == 1) {
			$menuData = \DbAuthMenu::find([
				'columns' => 'id,pid,title,url,module,controller,action,params,icon,rank',
				'conditions' => 'status=1',
				'order' => 'orderby ASC',
			])->toArray();
			return self::menusRecursion($menuData);
		}

		// 其它管理员
		$items = \DbAuthItem::query()
			->join('DbAuthMenu')
			->columns('DbAuthMenu.id,
				DbAuthMenu.pid,
				DbAuthMenu.title,
				DbAuthMenu.url,
				DbAuthMenu.module,
				DbAuthMenu.controller,
				DbAuthMenu.action,
				DbAuthMenu.params,
				DbAuthMenu.icon,
				DbAuthMenu.rank')
			->where("type=?0 and role_id=?1")
			->bind([0, $role_id])
			->orderBy('DbAuthMenu.orderby ASC')
			->execute()
			->toArray();
		return self::menusRecursion($items);
	}

	/**
	 * menus 递归
	 * @param  array  $menus
	 * @param  integer $pid
	 * @return array
	 */
	public static function menusRecursion($menus, $pid = 0) {
		$result = [];
		if (empty($menus)) {
			return $result;
		}
		foreach ($menus as $key => $value) {
			if ($value['pid'] == $pid) {
				$value['sub'] = self::menusRecursion($menus, $value['id']);
				$value['suburl'] = self::menusRecursionUrl($menus, $value['id']);
				$result[] = $value;
			}
		}
		return $result;
	}

	/**
	 * menus url 递归
	 * @param  array  $menus
	 * @param  integer $pid
	 * @return array
	 */
	public static function menusRecursionUrl($menus, $pid = 0) {
		$result = [];
		if (empty($menus)) {
			return $result;
		}
		foreach ($menus as $key => $value) {
			if ($value['pid'] == $pid) {
				$result[] = $value['url'];
			}
		}
		return $result;
	}

}