<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 24.11.2015 г.
 * Time: 11:18
 */

namespace Cms\Session;


interface ISession
{
    public function getSessionId();
    public function saveSession();
    public function destroySession();
    public function __get($sessId);
    public function __set($sessId, $value);
}