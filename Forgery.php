<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 16.11.2015 г.
 * Time: 0:31
 */

namespace Cms;


class Forgery
{
    private static $instance = null;
    private $forgeryToken = null;

    private function __construct()
    {
        $this->forgeryToken = $this->randomString();
    }

    private function randomString($length = 30) {
        $characters = '.,?/\-_%*&#@!()+=0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function getForgeryString()
    {
        return $this->forgeryToken;
    }

    public function saveForgeryString()
    {
        session_start();
        $_SESSION['forgery'] = $this->forgeryToken;
    }

    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new \Cms\Forgery();
        }
        return self::$instance;
    }
}