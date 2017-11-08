<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    Kevin
 * @time      2017/10/21 0021 上午 11:17
 */

use Phalcon\Mvc\User\Plugin;

/**
 * Class Layers
 * @package app\plugins
 */
class Layers extends Plugin
{
    /**
     * Layers constructor.
     * @param $di
     */
    public function __construct($di)
    {
        $this->di = $di;
        $this->auth = $this->session->get('auth');
    }

    /**
     * 权限验证
     * @param $action
     * @return bool
     */
    private function authAcl($action)
    {
        return true;
    }

    /**
     * @desc   获取权限
     * @access public
     * @return array
     */
    public function getPower()
    {
        $power = $this->di->get('session')->get($this->di->get('config')->params['login.power']);
        if ($power) {
            return $power;
        } else {
            return [];
        }
    }

    /**
     * @param string $url
     * @param string $title
     * @param array $params
     * @param int $width
     * @param int $height
     * @param string $class
     * @param string $icon
     *
     * @return string
     */
    public function open($url, $title = "", $params = [], $width = 800, $height = 600, $class = 'btn btn-primary btn-xs', $icon = '')
    {
        if ($this->getPower() != 'all' && !in_array($url, $this->getPower())) return '';
        $explodeUrl = explode("/", trim($url, "/"));
        $action = end($explodeUrl);

        // 权限校验
        if (self::authAcl($action) === false) {
            return "";
        }

        $urls = $this->url->get($url) . ($params ? "?" . http_build_query($params) : "");
        $html = '<a href="javascript:layers.frame(\'%s\', \'%s\', %s ,%s);" class="%s">%s %s</a>';

        return sprintf($html, $urls, $title, $width, $height, $class, $icon, $title);
    }

    /**
     * @param        $url
     * @param        $params
     * @param string $title
     *
     * @return mixed
     */
    public function cancel($url, $params, $title = '删除')
    {
        if ($this->getPower() != 'all' && !in_array($url, $this->getPower())) return '';
        $icon = '<i class="fa fa-trash-o"></i>';
        $html = '<a href="javascript:layers.del(\'%s\', \'%s\')" class="btn btn-danger btn-xs"> %s</a>';

        return sprintf($html, $this->url->get($url), $params, $title);
    }

    /**
     * @param        $url
     * @param        $params
     * @param string $title
     * @return mixed
     */
    public function actions($url, $params, $title = '操作', $btn = 'primary')
    {
        if ($this->getPower() != 'all' && !in_array($url, $this->getPower())) return '';
        $html = '<a href="javascript:layers.ajax(\'%s\', \'%s\', \'%s\')" class="btn btn-%s btn-xs">%s</a>';

        return sprintf($html, $this->url->get($url), $params, $title, $btn, $title);
    }
}