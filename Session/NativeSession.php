<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 24.11.2015 г.
 * Time: 11:23
 */

namespace Cms\Session;


class NativeSession implements \Cms\Session\ISession
{

    /**
     * NativeSession constructor.
     * @param $name
     * @param int $lifetime
     * @param null $path
     * @param null $domain
     * @param bool|false $secure
     */
    public function __construct($name, $lifetime = null, $path = null, $domain = null, $secure = false)
    {
        if(strlen(trim($name)) === 0) {
            $name = '__sess';
        }
        session_name($name);
        session_set_cookie_params($lifetime, $path, $domain, $secure, true);
        session_start();
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        return session_id();
    }

    public function saveSession()
    {
        session_write_close();
    }

    public function destroySession()
    {
        session_destroy();
    }

    public function clearSession($name)
    {
        unset($_SESSION[$name]);
    }

    public function printSession() {
        echo "<pre>".print_r($_SESSION, true)."</pre>";
    }

    /**
     * @param $name
     * @return string session name
     */
    public function __get($name)
    {
        return $_SESSION[$name];
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }
}