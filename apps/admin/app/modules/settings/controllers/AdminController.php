<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 8:57
 */

namespace app\modules\settings\controllers;

/**
 * @desc 管理员
 * Class AdminController
 */
class AdminController extends \BaseController
{

    /**
     * @desc 查看
     */
    public function indexAction()
    {
        $builder = $this->modelsManager->createBuilder()->from('\DbAuthUser');
        $pages = new \Phalcon\Paginator\Adapter\QueryBuilder([
            "builder" => $builder,
            "limit" => 20,
            "page" => (int)$this->request->getQuery("page", "int", 1),
        ]);
        $this->view->pages = $pages->getPaginate();
        $this->view->statuaData = ['不可用', '可用'];
    }

    /**
     * @desc 添加
     */
    public function addAction()
    {
        if ($this->request->isPost()) {
            $post = $this->request->getPost();

            $post['password_token'] = \Base::uniqueGuid();
            $post['password'] = $this->crypt->encryptBase64($this->crypt->encrypt($post['password']), $post['password_token'] . SAFE_KEY);
            $post['created_at'] = $post['updated_at'] = time();

            $model = new \DbAuthUser();
            $model->attributes = $post;
            if ($model->save()) {
                return parent::JsonFormat(200, $this->lang->t('app', 'add_suc'));
            }

            return parent::JsonFormat(500, \Base::modelError($model->getMessages()));
        }
        $this->view->model = new \DbAuthUser();
        $this->view->group = \app\modules\settings\models\Roles::findRolesByPid($this->auth['role_id']);

        $this->view->setMainView("../layer");
        return parent::render('form');
    }

    /**
     * @desc 编辑
     */
    public function editAction()
    {
        $id = $this->request->get("id");
        $adminData = \DbAuthUser::findFirstById($id);

        if ($this->request->isPost()) {
            $adminData = \DbAuthUser::findFirstById($this->request->getPost('id'));
            if (empty($adminData)) {
                return parent::JsonFormat(500, $this->lang->t('app', 'data_empty'));
            }
            if ($adminData->id == 1) {
                return parent::JsonFormat(500, $this->lang->t('app', 'request_error'));
            }
            $post = $this->request->getPost();

            $passwd = $post['password'];
            unset($post['password']);

            if (!empty($passwd)) {
                $post['password'] = $this->crypt->encryptBase64($this->crypt->encrypt($passwd), $adminData->password_token . SAFE_KEY);
            } else {
                $post['password'] = $adminData->password;
            }
            $post['token'] = \Base::uniqueGuid();
            $adminData->attributes = $post;
            if ($adminData->save()) {
                return parent::JsonFormat(200, $this->lang->t('app', 'update_suc'));
            }

            return parent::JsonFormat(500, \Base::modelError($adminData->getMessages()));
        }
        $this->view->model = $adminData;
        $this->view->group = \app\modules\settings\models\Roles::findRolesByPid($this->auth['role_id']);

        $this->view->setMainView("../layer");
        return parent::render('form');
    }

    /**
     * @desc 删除
     */
    public function deleteAction()
    {
        if ($this->request->isPost()) {
            $adminData = \DbAuthUser::findFirstById($this->request->getPost('id'));
            if (empty($adminData)) {
                return parent::JsonFormat(500, $this->lang->t('app', 'data_empty'));
            }
            if ($adminData->delete() == false) {
                return parent::JsonFormat(500, \Base::modelError($adminData->getMessages()));
            }
            return parent::JsonFormat(200, $this->lang->t('app', 'del_suc'));
        }
        return parent::JsonFormat(404, '404');
    }

    /**
     * @desc 操作日志
     */
    public function logsAction()
    {
        $user_id = $this->request->get('id', 'int');
        $builder = $this->modelsManager->createBuilder()->from('DbAuthLogs')->where("user_id={$user_id} and status=1")->orderBy('created_at desc');
        $pages = new \Phalcon\Paginator\Adapter\QueryBuilder([
            "builder" => $builder,
            "limit" => 10,
            "page" => (int)$this->request->getQuery("page", "int", 1),
        ]);
        $this->view->pages = $pages->getPaginate();

        $this->view->setMainView("../layer");
        return parent::render();
    }
}