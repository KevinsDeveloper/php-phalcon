<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    Kevin
 * @time      2017/10/21 0021 上午 11:17
 */

/**
 * Class Lang
 * @package app\plugins
 */
class Lang extends \Phalcon\Mvc\User\Plugin
{

    /**
     * @var object 配置信息
     */
    public static $config;
    public static $_files;

    /**
     * __construct
     */
    public function __construct($config)
    {
        self::$config = $config;
    }

    /**
     * @param string $file
     * @param $message
     * @return mixed
     * @throws \Exception
     */
    public function t($file = 'app', $message)
    {
        $request = new \Phalcon\Http\Request();
        $language = $request->getBestLanguage();
        $messageFile = self::$config->application->messageDir . strtolower($language) . "/{$file}.php";

        if (!file_exists($messageFile)) {
            throw new \Exception($messageFile . " not file!");
        }
        if (isset(self::$_files[$file]) && isset(self::$_files[$file][$message])) {
            return self::$_files[$file][$message];
        }
        $messageData = require $messageFile;
        self::$_files[$file] = $messageData;

        return isset($messageData[$message]) ? $messageData[$message] : $message;
    }

}
