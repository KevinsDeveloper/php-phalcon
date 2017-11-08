<?php

/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    Kevin
 * @time      2017/10/21 0021 上午 11:17
 */

namespace plugins\upload;

/**
 * 文件上传插件
 */
class Uploader
{

    public $_setting = [];                  //系统配置信息
    public $_errors = null;                 //错误信息
    public $_tmp_name = '';                 //临时文件
    public $_real_name = '';                //原始文件名
    public $_file_name = '';                //生成的文件完整路径
    public $_show_name = '';                //显示的文件完整路径
    public $_thumb_name = '';               //生成缩略图的完整路径
    public $_file_ext = '';                 //文件扩展名
    public $_file_size = '';                //文件大小
    public $_mime_type = '';                //MIME类型
    public $_is_image = false;              //是不是图片
    public $_rand_name = true;              //是否生成随机文件名
    public $_thumb_prefix = 'small_';       //缩略图前缀
    public $_image_path = 'images/'; //默认图片上传路径
    public $_thumb_path = 'thumbs/'; //默认缩略图上传路径
    public $_file_path = 'files/';  //默认文件上传路径

    /**
     * 初始化
     * @param type $setting
     * @return boolean
     */
    public function __construct($setting)
    {
        $this->_setting = [
            'file_ext' => 'bmp,png,jpg,jpeg,gif',
            'file_size' => '20480',
            'upload_domain' => isset($setting['upDomain']) ? $setting['upDomain'] : "",
        ];
        if (empty($this->_setting)) {
            $this->_errors = '请先配置文件上传设置';

            return false;
        }

        return true;
    }

    /**
     * 我需要把文件入库存储
     * @param $file
     * @param bool $small_thumb
     * @return bool
     */
    public function uploadFile($file, $small_thumb = false)
    {
        if (!$this->checkUpload($file)) {
            return false;
        }
        $show_path = ($this->_is_image === true) ? $this->_image_path : $this->_file_path;
        $show_path .= date('Ymd', time()) . '/';
        $save_path = UPLOAD_PATH . '/' . $show_path;
        $filename = $this->_rand_name ? substr(md5(uniqid('file')), 0, 11) . '.' . $this->_file_ext : $this->_real_name;
        if (!is_dir($save_path)) {
            mkdir($save_path, 0777, true);
        }
        $save_path .= $filename;
        $this->_show_name = $this->_setting['upload_domain'] . '/' . $show_path . $filename;
        $this->_file_name = '/' . $show_path . $filename;
        $mv = move_uploaded_file($this->_tmp_name, $save_path);
        if (!$mv) {
            $this->_errors = '文件上传失败！';

            return false;
        }

        return true;
    }

    /**
     * 校验上传文件是否符合要求(包括文件类型、大小)
     * @param type $file
     * @return boolean
     */
    public function checkUpload($file)
    {
        if (!$file || $file['error'] != UPLOAD_ERR_OK) {
            $this->_errors = '文件上传失败，请检查是否超出限制';

            return false;
        }
        $this->_tmp_name = $file['tmp_name'];
        $this->_real_name = $file['name'];
        $this->_file_ext = $this->getExt($file['name']);
        $this->_mime_type = $file['type'];
        $this->_file_size = $file['size'];

        if (in_array($this->_file_ext, explode(",", $this->_setting['file_ext']))) {
            $this->_is_image = true;
        }

        if (!in_array($this->_file_ext, explode(',', $this->_setting['file_ext']))) {
            $this->_errors = "禁止上传{$this->_file_ext}后缀的文件";

            return false;
        }

        if ($file['size'] > $this->_setting['file_size'] * 1024) {
            $this->_errors = "上传文件大小超出限制";

            return false;
        }

        if (!is_uploaded_file($this->_tmp_name)) {
            $this->_errors = "系统临时文件错误";

            return false;
        }

        return true;
    }

    /**
     * 取得上传文件的后缀
     * @access private
     * @param string $realname 文件名
     * @return boolean
     */
    private function getExt($realname)
    {
        $pathinfo = pathinfo($realname);

        return strtolower($pathinfo['extension']);
    }

}
