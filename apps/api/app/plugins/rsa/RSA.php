<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    whxu
 * @time      2017/9/6 11:32
 */

namespace plugins\rsa;

/**
 * RSA 加解密
 * Class RSA
 * @package plugins\rsa
 */
class RSA
{
    /**
     * @var string openssl public key
     */
    private $public_key;

    /**
     * @var string openssl private key
     */
    private $private_key;

    /**
     * @var string 加密后的字符
     */
    private $crypted;

    /**
     * @var string 解密后的数据
     */
    private $decrypted;

    /**
     * RSA constructor.
     * @param $options
     */
    public function __construct()
    {
        $this->public_key = file_get_contents(__DIR__ . '/pem/public_key.pem');
        $this->private_key = file_get_contents(__DIR__ . '/pem/private_key.pem');
    }

    /**
     * 加密
     * @param  $data 加密数据
     * @return string
     */
    public function encrypt($data)
    {
        $cryptData = is_array($data) ? json_encode($data) : (string)$data;
        // 加密
        openssl_private_encrypt($cryptData, $crypted, $this->private_key);
        return base64_encode($crypted);
    }

    /**
     * 解密
     * @param  string $encrypt 加密过的字符串
     * @return string
     */
    public function decrypt($encrypt)
    {
        openssl_public_decrypt(base64_decode($encrypt), $decrypted, $this->public_key);
        $this->decrypted = $decrypted;
        return $this;
    }

    /**
     * 返回数组格式
     * @return array
     */
    public function toArray()
    {
        if (!$this->decrypted || empty($this->decrypted)) {
            return $this->decrypted;
        }

        return json_decode($this->decrypted, true);
    }

    /**
     * 返回字符串格式
     * @return string
     */
    public function toString()
    {
        return (string)$this->decrypted;
    }
}