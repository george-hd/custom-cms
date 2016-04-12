<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 20.11.2015 г.
 * Time: 9:48
 */

namespace Cms;


class InputData
{
    private static $instance = null;
    private $getData = [];
    private $postData = [];
    private $cookies = [];

    private function __construct()
    {
        $this->cookies = $_COOKIE;
    }

    /**
     * @param array $getData
     */
    public function setGetData($getData)
    {
        if(is_array($getData)) {
            $this->getData = $getData;
        }
    }

    /**
     * @param array $postData
     */
    public function setPostData($postData)
    {
        if(is_array($postData)) {
            $this->postData = $postData;
        }
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasGet($key)
    {
        return array_key_exists($key, $this->getData);
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasPost($key)
    {
        return array_key_exists($key, $this->postData);
    }

    /**
     * @return bool
     */
    public function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET' ? true : false;
//        return (empty($this->getData) ? false : true);
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST' ? true : false;
//        return (empty($this->postData) ? false : true);
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasCookie($name)
    {
        return array_key_exists($name, $this->cookies);
    }

    /**
     * @return array
     */
    public function getGet() {
        return $this->getData;
    }

    /**
     * @return array
     */
    public function getPost() {
        return $this->postData;
    }

    /**
     * @param $key
     * @param null $normalize
     * @param null $default
     * @return float|null|string
     */
    public function getGetByKey($key, $normalize = null, $default = null)
    {
        if($this->hasGet($key)) {
            if($normalize != null) {
                return \Cms\Common::normalize($this->getData[$key], $normalize);
            }
            return $this->getData[$key];
        }
        return $default;
    }

    /**
     * @param $key
     * @param null $normalize
     * @param null $default
     * @return float|null|string
     */
    public function getPostById($key, $normalize = null, $default = null)
    {
        if($this->hasPost($key)) {
            if($normalize != null) {
                return \Cms\Common::normalize($this->postData[$key], $normalize);
            }
            return $this->postData[$key];
        }
        return $default;
    }

    /**
     * @param $name
     * @param null $normalize
     * @param null $default
     * @return float|null|string
     */
    public function getCookie($name, $normalize = null, $default = null)
    {
        if($this->hasCookie($name)) {
            if($normalize != null) {
                return \Cms\Common::normalize($this->cookies[$name], $normalize);
            }
            return $this->cookies[$name];
        }
        return $default;
    }

    /**
     * @return \Cms\InputData
     */
    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new \Cms\InputData();
        }
        return self::$instance;
    }
}