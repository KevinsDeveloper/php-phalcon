<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 8:57
 */

use Phalcon\Mvc\Controller;
use plugins\json\JResponse as JsonResponse;

/**
 * Class BaseController
 */
class BaseController extends Controller
{
    /**
     * @var string reponse ret
     */
    protected $ret = 200;

    /**
     * @var string reponse msg
     */
    protected $msg = 'success';

    /**
     * @var array admin auth
     */
    protected $auth;

    /**
     * controller onConstruct
     */
    public function onConstruct()
    {
    }

    /**
     * controller initialize
     */
    public function initialize()
    {
        if ($this->request->isAjax() || $this->request->isPost()) {
            // 关闭视图功能
            $this->view->disable();
            $this->response->setContentType("application/json", "UTF-8");
        }
    }

    /**
     * beforeExecuteRoute
     * @param $dispatcher
     * @return bool
     */
    public function beforeExecuteRoute($dispatcher)
    {
        if ($dispatcher->getControllerName() == 'login') {
            return true;
        }

        $di = $this->getDI();
        $auth = $this->session->get($this->config->params['login.session']);
        if (empty($auth)) {
            $this->response->redirect($this->url->get('/login', [
                'redirect' => urlencode($di->get('request')->getURI()),
            ]));
            return false;
        }

        $power = new \LoginAuth();
        if (empty($power->getResource())) {
            $this->response->redirect($this->url->get('/login'),[
                'redirect' => urlencode($di->get('request')->getURI()),
            ]);
        } else if (!$power->isAllow()) {
            if ($this->request->isAjax()) {
                $this->JsonFormat(500, $this->lang->t('app', 'power_error'));
                return false;
            } else {
                $this->response->redirect($this->url->get('/index/error'));
                return false;
            }
        }

        $this->auth = $auth;
        $this->view->auth = $auth;

        $parseUrl = parse_url($this->request->getURI());
        $this->view->urlPath = $parseUrl['path'];
        $this->view->urlModule = explode('/', trim($this->view->urlPath, '/'));

        // 权限查询
        $this->view->menus = \app\modules\settings\models\Items::getAdminItems($auth['role_id']);

        // 日志系统
        if ($this->request->isPost()) {
            AuthLogs::app($this->auth)->afterExecute($this->request, $dispatcher);
        }

        return true;
    }

    /**
     * afterExecuteRoute
     * @param $dispatcher
     * @return bool
     */
    public function afterExecuteRoute($dispatcher)
    {
        $getReturnedValue = $dispatcher->getReturnedValue();

        // 如果是ajax请求，则返回JSON
        if ($this->request->isAjax() && is_array($getReturnedValue)) {
            return JsonResponse::app()->success($getReturnedValue, $this->ret, $this->msg);
        }

        return true;
    }

    /**
     * @param $ret
     * @param $msg
     * @param $status
     * @return \Phalcon\Http\Response
     */
    protected function JsonFormat($ret, $msg, $status = 200)
    {
        return JsonResponse::app()->end($ret, $msg, $status);
    }

    /**
     * render module view
     * @param string $view
     * @return mixed
     */
    protected function render($view = '')
    {
        return $this->view->pick($this->router->getControllerName() . '/' . (!empty($view) ? $view : $this->router->getActionName()));
    }

    /**
     * action error
     * @param int $ret 状态
     * @param string $msg 提示语
     * @return array
     */
    protected function error($ret, $msg)
    {
        return ['ret' => $ret, 'msg' => $msg];
    }

    /**
     * action success
     * @param array $result 数据
     * @return array
     */
    protected function success($data, $ret = 200, $msg = '')
    {
        return JsonResponse::app()->success($data, $ret, $msg);
    }

    /**
     * @param $key
     * @return int
     * @throws \yii\web\HttpException
     */
    protected function getId($key = 'id')
    {
        $get = intval($this->request->get($key));
        if ($get <= 0) {
            return $this->JsonFormat(500, $this->lang->t('app', 'params_err'));
        }

        return $get;
    }

    /**
     * @param string $key
     * @return int
     * @throws \yii\web\HttpException
     */
    protected function postId($key = 'id')
    {
        $post = intval($this->request->getPost($key));
        if ($post <= 0) {
            return $this->JsonFormat(500, $this->lang->t('app', 'params_err'));
            //throw new \Phalcon\Http\Response\Exception($this->lang->t('app', 'params_err'), '500');
        }
        return $post;
    }
}