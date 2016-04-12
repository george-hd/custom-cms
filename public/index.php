<?php
//ini_set('display_errors', 2);
error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(E_ALL);

/**
 * Created by bro555555.
 * User: George
 * Date: 6.11.2015 г.
 * Time: 18:55
 */

include_once '../App.php';
$app = \Cms\App::getInstance();
$app->run();