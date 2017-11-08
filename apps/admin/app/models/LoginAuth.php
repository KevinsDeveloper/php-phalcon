<?php

use Phalcon\Http\Request;

class LoginAuth extends \Phalcon\Mvc\Model
{
    /**
     * @desc
     * @access public
     * @param int $role_id 角色ID
     * @return array
     */
    public function getRolePower($role_id)
    {
        if ($role_id == 1) {
            return 'all';
        }
        $power = ['/index/index', '/index/error', '/index/main', '/index/info'];

        $find = \DbAuthItem::find('role_id=' . $role_id)->toArray();
        if ($find) {
            $power = array_merge($power, array_column($find, 'url'));
        }
        return $power;
    }

    /**
     * @desc   保存当前角色权限
     * @access public
     * @return array
     */
    public function addResource($role_id)
    {
        $this->getDI()->get('session')->set($this->getDI()->get('config')->params['login.power'], $this->getRolePower($role_id));
    }

    /**
     * @desc
     * @access public
     * @return array
     */
    public function getResource()
    {
        return $this->getDI()->get('session')->get($this->getDI()->get('config')->params['login.power']);
    }

    /**
     * @desc   检查操作权限
     * @access public
     * @param  string $url
     * @return array
     */
    public function isAllow()
    {
        $request = new Request();
        $reqUrl = $request->getURI();
        $url = explode('?', $reqUrl);
        $url = $url[0];
        if ($url != '/') $url = rtrim($url, '/');
        if (strpos($url, 'Login') === true) {
            return true;
        }
        $power = $this->getResource();
        if ($power == 'all' || $url == '/' || in_array($url, $power)) {
            return true;
        } else {
            return false;
        }
    }
}

?>