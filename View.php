<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 11.11.2015 г.
 * Time: 16:59
 */

namespace Cms;

class View
{
    private static $parts = array();
    private $section = array();
//    private $viewFolder = null;

    public function __construct()
    {
//        if(\Cms\FrontController::getInstance()->getViewFolder() != null) {
//            $this->viewFolder = \Cms\FrontController::getInstance()->getViewFolder() . DIRECTORY_SEPARATOR;
//        }
        $args = func_get_args();
        if (count($args) === 0) {
            echo $this->onlyModel();
        } elseif (count($args) === 1) {
            echo $this->onlyModel($args[0]);
        } else {
            echo $this->viewAndModel($args[0], $args[1]);
        }
    }

    public static function appendPage($k, $v)
    {
        $v = str_replace('.', '/', $v);
        self::$parts[$k] = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $v . '.php';
    }


//    private function onlyView($view)
//    {
//        $file = \Cms\App::getInstance()->getConfig()->app['namespace']['Cms\Views']
//            . DIRECTORY_SEPARATOR
//            . $view . '.php';
//
//        $file = realpath($file);
//        if (file_exists($file) && is_readable($file)) {
//            ob_start();
//            include $file;
//            echo ob_get_clean();
//        }
//    }


    /**
     * @param $model
     * @return string
     * @throws \Exception
     */
    private function onlyModel($model = null)
    {
        $file = \Cms\App::getInstance()->getConfig()->app['namespace']['Cms\Views']
            . DIRECTORY_SEPARATOR
            . $this->viewFolder
            . str_replace('Controller', '', \Cms\FrontController::getInstance()->getController())
            . DIRECTORY_SEPARATOR
            . \Cms\FrontController::getInstance()->getMethod() . '.php';

        if(count(self::$parts) > 0) {
            foreach (self::$parts as $k => $v) {
                $part = realpath($v);
                if($part && is_file($part) && is_readable($part)) {
                    ob_start();
                    include $part;
                    $this->section[$k] = ob_get_clean();
                }
            }
        }

        $file = realpath($file);
        if (file_exists($file) && is_readable($file)) {
            ob_start();
            include $file;
            return ob_get_clean();
        } else {
            throw new \Exception('Can not include file ' .$file, 500);
        }
    }

    /**
     * @param $view
     * @param $model
     * @return string
     * @throws \Exception
     */
    private function viewAndModel($view, $model)
    {
        $view = str_replace('.', '/', $view);
        $file = \Cms\App::getInstance()->getConfig()->app['namespace']['Cms\Views']
            . DIRECTORY_SEPARATOR
            . $view . '.php';

        if(count(self::$parts) > 0) {
            foreach (self::$parts as $k => $v) {
                $part = realpath($v);
                if($part && is_file($part) && is_readable($part)) {
                    ob_start();
                    include $part;
                    $this->section[$k] = ob_get_clean();
                }
            }
        }
        $file = realpath($file);
        if (file_exists($file) && is_readable($file)) {
            ob_start();
            include $file;
            return ob_get_clean();
        } else {
            throw new \Exception('Can not include file ' .$file, 500);
        }
    }
}