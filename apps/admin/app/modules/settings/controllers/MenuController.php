<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 8:57
 */

namespace app\modules\settings\controllers;

use Phalcon\Mvc\View;

/**
 * @desc 菜单管理
 * Class MenuController
 * @package app\modules\settings\controllers
 */
class MenuController extends \BaseController
{

    /**
     * initialize
     */
    public function initialize()
    {
        parent::initialize();
        $this->view->menuStatus = ['禁用', '可用'];
    }

    /**
     * @desc 查看
     */
    public function indexAction()
    {
        $menuData = \app\modules\settings\models\Menus::getMenuList();

        $treeClass = new \app\modules\settings\models\Tree($this);
        $treeClass->tmplate = $this->lang->t('setting', 'menuList');
        $treeClass->init($menuData);

        $this->view->menuTable = $treeClass->getShiftTree();
    }

    /**
     * @desc 添加
     */
    public function addAction()
    {
        // 执行写入菜单
        if ($this->request->isPost()) {
            $adminMenu = new \DbAuthMenu();
            $parentMenu = \DbAuthMenu::findFirstById($this->request->getPost('pid', 'int'));

            $post = $this->request->getPost();
            $exp = explode("/", $post['url']);
            $post['rank'] = !empty($parentMenu) ? $parentMenu->rank + 1 : 0;
            $post['module'] = isset($exp[1]) ? $exp[1] : "#";
            $post['controller'] = isset($exp[2]) ? $exp[2] : "#";
            $post['action'] = isset($exp[3]) ? $exp[3] : "#";

            if ($adminMenu->save($post)) {
                if (!empty($parentMenu)) {
                    $parentMenu->save();
                }

                return parent::JsonFormat(200, '添加菜单成功');
            }
            return parent::JsonFormat(['ret' => 0, 'msg' => parent::modelError($adminMenu->getMessages())]);
        }

        $menuData = \app\modules\settings\models\Menus::getMenuList(0);
        $treeClass = new \app\modules\settings\models\Tree($this);
        $treeClass->tmplate = $this->lang->t('setting', 'menuOption');
        $treeClass->init($menuData);

        $this->view->menuOption = $treeClass->getShiftTree();
        $this->view->model = new \DbAuthMenu();

        $this->view->setMainView("../layer");
        return parent::render('form');
    }

    /**
     * @desc 编辑
     */
    public function editAction()
    {
        if ($this->request->isPost()) {
            $adminMenu = \DbAuthMenu::findFirstById($this->request->getPost('id', 'int'));
            $post = $this->request->getPost();

            $exp = explode("/", $post['url']);
            $post['module'] = isset($exp[1]) ? $exp[1] : "#";
            $post['controller'] = isset($exp[2]) ? $exp[2] : "#";
            $post['action'] = isset($exp[3]) ? $exp[3] : "#";

            $pid = $this->request->getPost('pid', 'int');
            if ($pid > 0) {
                $parentMenu = \DbAuthMenu::findFirstById($adminMenu->pid);
                $post['rank'] = $parentMenu->rank + 1;
            }
            $adminMenu->attributes = $post;
            if ($adminMenu->save()) {
                return parent::JsonFormat(200, '编辑菜单成功');
            }

            return parent::JsonFormat(500, \Base::modelError($adminMenu->getMessages()));
        }
        $editMenuData = \DbAuthMenu::findFirstById($this->request->get('id'));
        $menuData = \app\modules\settings\models\Menus::getMenuList(0);
        $treeClass = new \app\modules\settings\models\Tree($this);
        $treeClass->tmplate = $this->lang->t('setting', 'menuOption');
        $treeClass->selected = $editMenuData->pid;
        $treeClass->init($menuData);

        $this->view->menuOption = $treeClass->getShiftTree();
        $this->view->model = $editMenuData;
        $this->view->setMainView("../layer");
        return parent::render('form');
    }

    /**
     * @desc 删除
     * @return \Phalcon\Http\Response
     */
    public function deleteAction()
    {
        $menuData = \DbAuthMenu::findFirstById($this->request->getPost('id'));
        if (empty($menuData)) {
            return parent::JsonFormat(500, '数据异常删除失败');
        }
        if ($menuData->delete() == false) {
            return parent::JsonFormat(500, \Base::modelError($menuData->getMessages()));
        }

        return parent::JsonFormat(200, '删除成功');
    }
}