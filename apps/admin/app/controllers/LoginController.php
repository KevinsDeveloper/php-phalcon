<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 8:57
 */

use Phalcon\Filter;
use Phalcon\Mvc\View;
use plugins\captcha\Captcha;
use plugins\json\JResponse as JsonResponse;

/**
 * Class LoginController
 */
class LoginController extends Phalcon\Mvc\Controller
{

    /**
     * 登录首页
     */
    public function indexAction()
    {
        $this->view->disableLevel(
            [
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]
        );

        $this->view->redirect = $this->request->get('redirect', 'string', '/');
    }

    /**
     * 执行登录
     * @return array
     */
    public function doAction()
    {
        $this->view->disable();

        if ($this->request->isAjax() && $this->request->isPost()) {

            $filter = new Filter();
            $account = $filter->sanitize($this->request->getPost('account'), "string");
            $password = $filter->sanitize($this->request->getPost('password'), "string");
            $captcha = $filter->sanitize($this->request->getPost('captcha'), "int");

            // 判断是否为空
            if (empty($account) || empty($password) || empty($captcha)) {
                return JsonResponse::app()->error(500, "Request Exception");
            }

            // 校验验证码
            if (!$this->session->has('captchaCode') || $this->session->get('captchaCode') != $captcha) {
                return JsonResponse::app()->error(500, 'Captcha Error', 200);
            }

            // 执行登录
            $adminData = \DbAuthUser::findFirstByAccount($account);

            if (empty($adminData)) {
                return JsonResponse::app()->error(500, 'Account Error', 200);
            }
            // 账号禁止登陆
            if ($adminData->status != 1) {
                return JsonResponse::app()->error(500, 'Account Close', 200);
            }
            // 校验密码
            $decrypt = $this->crypt->decrypt($this->crypt->decryptBase64($adminData->password, $adminData->password_token . SAFE_KEY));
            if ($password != $decrypt) {
                return JsonResponse::app()->error(500, 'Passwd Error', 200);
            }
            // 写入session
            $sessionData = $adminData->toArray(['id', 'role_id', 'account', 'realname', 'login_at']);
            $this->session->set($this->config->params['login.session'], $sessionData);
            $adminData->login_at = time();
            $adminData->save();
            // 登录日志
            AuthLogs::app($sessionData)->save('登录--成功', $this->request->get());

            // 添加角色权限
            $auth = new \LoginAuth();
            $auth->addResource($adminData->role_id);
            return JsonResponse::app()->success(['redirect' => urldecode($this->request->getPost('redirect'))]);
        }
        return JsonResponse::app()->success(['redirect' => $this->url->get('/login')]);
    }

    /**
     * 生成图片验证码
     * @access public
     */
    public function captchaAction()
    {
        $this->view->disable();
        $captcha = new Captcha([
            'width' => 124,
            'height' => 35,
            'fontsize' => 14,
            'backcolor' => '#fff',
        ]);
        $captcha->getReckonImg();
        $this->session->set('captchaCode', $captcha->getCode());
    }

    /**
     * 退出
     * @return bool
     */
    public function outAction()
    {
        $auth = $this->session->get($this->config->params['login.session']);
        // 登录日志
        AuthLogs::app($auth)->save('退出--成功', $this->request->get());

        $this->session->remove($this->config->params['login.session']);
        $this->session->destroy();
        $this->response->redirect('/login');
        return false;
    }
}