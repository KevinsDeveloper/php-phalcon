<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 8:57
 */

use Phalcon\Http\Request;

/**
 * Class IndexController
 */
class IndexController extends BaseController
{

    /**
     * 后台首页
     * @return string
     */
    public function indexAction()
    {
    }

    /**
     * 默认页
     */
    public function mainAction()
    {

    }

    /**
     * @desc   管理员个人资料
     * @access public
     * @return array
     */
    public function infoAction()
    {
        $session = $this->session->get($this->config->params['login.session']);
        if (empty($session)) $this->response->redirect('/login');
        $adminData = \DbAuthUser::findFirstById($session['id']);
        if ($this->request->isPost()) {
            if (empty($adminData)) {
                return parent::JsonFormat(500, $this->lang->t('app', 'data_empty'));
            }
            $post = $this->request->getPost();
            if ($post['password'] && !$post['qpassword']) {
                return parent::JsonFormat(500, $this->lang->t('app', 'qpwd_empty'));
            }
            if ($post['password'] && $post['qpassword'] && $post['password'] != $post['qpassword']) {
                return parent::JsonFormat(500, $this->lang->t('app', $this->lang->t('app', 'pwd_diff')));
            }
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
                return parent::success('', '', $this->lang->t('app', 'update_suc'));
            }

            return parent::JsonFormat(500, \Base::modelError($adminData->getMessages()));
        }
        $this->view->model = $adminData;
        $this->view->setMainView("mini");
    }

    /**
     * @desc   错误提示页
     * @access public
     * @return array
     */
    public function errorAction($status = 500)
    {

    }
}