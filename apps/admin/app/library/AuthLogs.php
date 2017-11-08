<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    Kevin
 * @time      2017/10/21 0021 上午 11:17
 */

class AuthLogs
{
    /**
     * @var 管理员
     */
    public $auth;

    /**
     * @var null 静态变量保存全局实例
     */
    private static $_instance = null;

    /**
     * @param $auth 管理员
     * @return Logs|null
     */
    public static function app($auth)
    {
        if (is_null(self::$_instance) || isset(self::$_instance)) {
            self::$_instance = new self();
            self::$_instance->auth = $auth;
        }
        return self::$_instance;
    }

    /**
     * 添加日志
     * @param $actionname 添加日志
     * @param $content 日志内容
     * @return bool
     */
    public function save($actionname, $content)
    {
        if (empty($this->auth)) {
            return false;
        }

        if (is_array($content)) {
            $content = $this->getContent($content);
        }

        $model = new \DbAuthLogs();
        $model->user_id = $this->auth['id'];
        $model->role_id = $this->auth['role_id'];
        $model->account = $this->auth['account'];
        $model->realname = $this->auth['realname'];
        $model->actionname = $actionname;
        $model->content = $content;
        $model->created_at = time();

        if (!$model->save()) {
            return false;
        }
        return true;
    }

    /**
     * @param $request
     * @param $dispatcher
     * @return bool
     */
    public function afterExecute($request, $dispatcher)
    {
        $modelName = $dispatcher->getModuleName();
        $controllerName = ucfirst($dispatcher->getControllerName()) . "Controller";
        $actionName = $dispatcher->getActionName() . "Action";
        $namespace = sprintf("\app\modules\%s\controllers\%s", $modelName, $controllerName);
        $class = new $namespace();

        $classDesc = $this->getClassDesc($class, $namespace);
        $methodDesc = $this->getMethodDesc($class, $actionName);

        $actionname = $classDesc . '--' . $methodDesc;
        $content = $this->getContent($request->get());

        return $this->save($actionname, $content);
    }

    /**
     * @param $requestData
     * @return null|string
     */
    private function getContent($requestData)
    {
        $result = null;
        if (empty($requestData)) {
            return $result;
        }

        foreach ($requestData as $key => $val) {
            if (is_array($val)) {
                $val = json_encode($val);
            }
            if (strlen($val) > 200) {
                continue;
            }
            if ($key == 'password') {
                continue;
            }
            $result .= $key . ':' . $val . '，';
        }
        return trim($result, '，');
    }

    /**
     * @param $class
     * @param $className
     * @return string
     */
    private function getClassDesc($class, $className = '')
    {
        $reflection = new \ReflectionClass($class);
        $docComment = $reflection->getDocComment();
        preg_match_all('/@desc(.*?)\n/', $docComment, $flag);

        return !empty($flag[1]) ? trim($flag[1][0], ' ') : $className;
    }

    /**
     * @param $class
     * @param string $action
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