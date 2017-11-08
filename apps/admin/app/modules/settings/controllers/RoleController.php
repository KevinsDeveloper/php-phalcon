<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 8:57
 */

namespace app\modules\settings\controllers;

use DbAuthRole;

/**
 * @desc 角色管理
 * Class RoleController
 */
class RoleController extends \BaseController
{

    /**
     * initialize
     */
    public function initialize()
    {
        parent::initialize();

        $this->view->statusData = ['不可用', '可用'];
    }

    /**
     * @desc 查看
     */
    public function indexAction()
    {
        $conditions = '';
        if ($this->auth['role_id'] != 1) {
            $conditions = 'pid=' . $this->auth['role_id'];
        }
        $builder = $this->modelsManager->createBuilder()->from('DbAuthRole')->where($conditions);
        $pages = new \Phalcon\Paginator\Adapter\QueryBuilder([
            "builder" => $builder,
            "limit" => 20,
            "page" => (int)$this->request->getQuery("page", "int", 1),
        ]);

        $list = $pages->getPaginate();
        $treeClass = new \app\modules\settings\models\Tree($this);
        $treeClass->init($list->items->toArray());
        $list->items = $treeClass->setNameTree('role_name', $this->auth['role_id'] != 1 ? $this->auth['role_id'] : 0);
        $this->view->pages = $list;
    }

    /**
     * @desc 添加
     */
    public function addAction()
    {
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $model = new \DbAuthRole();
            $model->created_at = time();
            $model->rank = \app\modules\settings\models\Roles::getRankByPid($post['pid']);
            if ($post['pid']) {
                $parent = $model->findFirstById($post['pid'])->toArray();
                $tree = \Tree::getInstance()->getTreeInfo($parent);
            } else {
                $tree = \Tree::getInstance()->defTree;

            }
            $model->tree_lt = $tree['tree_lt'];
            $model->tree_rt = $tree['tree_rt'];
            $this->db->begin();
            if ($model->save($post)) {
                # 更新树
                if ($post['pid']) {
                    $refTree = \Tree::getInstance()->addTree(get_class($model), $parent);
                    if ($refTree) {
                        foreach ($refTree as $key => $value) {
                            $query = $this->modelsManager->executeQuery($value);
                            if (!$query->success()) {
                                $this->db->rollback();
                                return parent::JsonFormat(500, $this->lang->t('app', 'add_fail'));
                            }
                        }
                    }
                }
                // 更新当前记录的树ID
                $model->tree_rank = $post['pid'] == 0 ? $model->id : $tree['tree_rank'];
                if (!$model->save()) {
                    $this->db->rollback();
                    return parent::JsonFormat(500, \Base::modelError($model->getMessages()));
                }
                $this->db->commit();
                return parent::JsonFormat(200, '添加角色成功');
            }

            return parent::JsonFormat(500, \Base::modelError($model->getMessages()));
        }
        $this->view->model = new \DbAuthRole();
        $this->view->parentRoles = \app\modules\settings\models\Roles::findRolesByPid($this->auth['role_id']);

        $this->view->setMainView("../layer");
        return parent::render('form');
    }

    /**
     * @desc 编辑
     */
    public function editAction()
    {
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $model = \DbAuthRole::findFirstById($this->request->getPost('id', 'int'));
            $model->updated_at = time();
            $model->rank = \app\modules\settings\models\Roles::getRankByPid($post['pid']);
            if ($model->id == 1) {
                return parent::JsonFormat(500, '超级管理员禁止编辑');
            }
            $oldPid = $model->pid;
            $oldTree = ['tree_lt' => $model->tree_lt, 'tree_rt' => $model->tree_rt, 'tree_rank' => $model->tree_rank];
            $this->db->begin();
            if ($post['pid'] != $oldPid) {
                if ($post['pid']) {
                    $parent = $model->findFirstById($post['pid'])->toArray();
                    $tree = \Tree::getInstance()->getTreeInfo($parent);
                } else {
                    $tree = \Tree::getInstance()->defTree;
                }
            }
            if ($model->save($post)) {
                # 更新树
                if ($post['pid'] != $oldPid) {
                    $refTree = \Tree::getInstance()->updateTree(get_class($model), $oldTree, $parent);
                    if ($refTree) {
                        foreach ($refTree as $key => $value) {
                            $query = $this->modelsManager->executeQuery($value);
                            if (!$query->success()) {
                                $this->db->rollback();
                                return parent::JsonFormat(500, $this->lang->t('app', 'update_fail'));
                            }
                        }
                    }

                    // 更新当前记录的树ID
                    $model->tree_rank = $post['pid'] == 0 ? $model->id : $tree['tree_rank'];
                    if (!$model->save()) {
                        $this->db->rollback();
                        return parent::JsonFormat(500, \Base::modelError($model->getMessages()));
                    }
                }

                $this->db->commit();
                return parent::JsonFormat(200, '编辑角色成功');
            }

            return parent::JsonFormat(500, \Base::modelError($model->getMessages()));
        }
        $this->view->model = \DbAuthRole::findFirstById($this->request->get('id', 'int'));
        $this->view->parentRoles = \app\modules\settings\models\Roles::findRolesByPid($this->auth['role_id']);

        $this->view->setMainView("../layer");
        return parent::render('form');
    }

    /**
     * @desc 删除
     */
    public function deleteAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id', 'int');
            $model = \DbAuthRole::findFirstById($id);
            if ($model->id == 1) {
                return parent::JsonFormat(500, '超级管理员禁止删除');
            }
            $son = \DbAuthRole::findFirst('pid=' . $id);
            if ($son && count($son->toArray()) > 0) {
                return parent::JsonFormat(500, '角色下有成员，不允许删除' . count($son));
            }
            $admin = \DbAuthUser::findFirst('role_id=' . $id);
            if ($admin && count($admin->toArray()) > 0) {
                return parent::JsonFormat(500, '角色下有管理员，不允许删除');
            }
            $this->db->begin();
            $tree = ['tree_lt' => $model->tree_lt, 'tree_rt' => $model->tree_rt, 'tree_rank' => $model->tree_rank];
            if ($model->delete() === false) {
                $this->db->rollback();
                return parent::JsonFormat(500, \Base::modelError($model->getMessages()));
            }
            $refTree = \Tree::getInstance()->delTree(get_class($model), $tree);
            if ($refTree) {
                foreach ($refTree as $key => $value) {
                    $query = $this->modelsManager->executeQuery($value);
                    if (!$query->success()) {
                        $this->db->rollback();
                        return parent::JsonFormat(500, $this->lang->t('app', 'del_err'));
                    }
                }
            }
            $this->db->commit();
            return parent::JsonFormat(200, '删除成功');
        }

        return parent::JsonFormat(500, '请求异常');
    }

    /**
     * @desc 权限
     */
    public function powerAction()
    {
        $roleData = \DbAuthRole::findFirstById($this->request->get('id'));
        if (empty($roleData)) {
            throw new \Exception("None Data Request", 502);
        }
        $findMenus = \app\modules\settings\models\Menus::getMenuList();
        // 接受数据
        if ($this->request->isPost()) {
            $power = $this->request->getPost("power");
            if (empty($power)) {
                return parent::JsonFormat(500, '请选择要设置的权限');
            }
            //var_dump($power);exit;
            $menus = $actions = [];
            foreach ($power as $key => $val) {
                if (!isset($val['url']) || empty($val['url'])) {
                    continue;
                }
                $menus[] = [
                    'role_id' => $roleData->id,
                    'menu_id' => $key,
                    'url' => $findMenus[$key]['url'],
                ];
                foreach ($val['url'] as $k => $v) {
                    $actions[] = [
                        'role_id' => $roleData->id,
                        'menu_id' => $key,
                        'type' => 1,
                        'url' => $v,
                    ];
                }
            }
            if (count($menus) == 0 && count($actions) == 0) {
                return parent::JsonFormat(500, '请选择要设置的权限');
            }

            // 开始事务执行
            $this->db->begin();
            if (!\DbAuthItem::find(['conditions' => 'role_id=?0', 'bind' => [$roleData->id]])->delete()) {
                $this->db->rollback();

                return parent::JsonFormat(500, '设置权限失败');
            }
            // 写入菜单
            foreach ($menus as $menu) {
                $model = new \DbAuthItem();
                $model->attributes = $menu;
                $model->save();
            }
            // 写入动作
            foreach ($actions as $action) {
                $model = new \DbAuthItem();
                $model->attributes = $action;
                $model->save();
            }
            $this->db->commit();

            return parent::JsonFormat(200, '设置成功');
        }

        $actionModel = new \app\modules\settings\models\Actions();
        $actionModel->init([
            'arr' => $findMenus,
            'tmplate' => $this->lang->t('setting', 'actionList'),
            'labelTemplate' => $this->lang->t('setting', 'actionLabel'),
            'power' => \DbAuthItem::find(["conditions" => "role_id=?0", "bind" => [$roleData->id]]),
        ]);

        $this->view->actionData = $actionModel->getActions();
        $this->view->model = $roleData;
        $this->view->setMainView("../layer");
    }
}