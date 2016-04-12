<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 6.11.2015 г.
 * Time: 19:10
 */

namespace Cms;
header('Content-Type: text/html; charset=utf-8');

final class Loader
{
    private static $namespaces = array();

    private function __construct()
    {

    }

    /**
     * @param string $namespace
     * @param string $path
     * @throws \Exception
     * @return void
     */
    public static function registerNamespace($namespace, $path)
    {
        if (strlen(trim($namespace)) > 0) {
            $path = realpath($path);
            if ($path && is_dir($path) && is_readable($path)) {
                self::$namespaces[$namespace . DIRECTORY_SEPARATOR] = $path . DIRECTORY_SEPARATOR;
            } else {
                throw new \Exception('Invalid namespace path ' . $path);
            }
        } else {
            throw new \Exception('Invalid namespace ' . $namespace);
        }
    }

    public static function registerAutoload()
    {
        spl_autoload_register(array('\Cms\Loader', 'loadClass'));
    }

    /**
     * @param string path to the class
     * @throws \Exception
     * @return void
     */
    public static function loadClass($class)
    {
//        echo 'class = ' . $class . '<br>';
        foreach (self::$namespaces as $k => $v) {
            if (stripos($class, $k) === 0) {
//                echo 'namespace name = ' . $class . ' -> ' . $k . '<br>';
//                echo  'f = ' .(substr_replace($class, $v, 0, strlen($k)) . '.php'); echo '<br>';
                $file = realpath(substr_replace($class, $v, 0, strlen($k)) . '.php');
//                echo 'file = ' . $file .'<br>';
                if ($file && is_readable($file) && is_file($file)) {
//                    echo $file . '<br>';
                    include_once $file;
                } else {
                    throw new \Exception('Error loading file ' . $file, 500);
                }
            }
        }
    }

    /**
     * @param string $namespaces []
     * @throws \Exception
     * @return void
     */
    public static function registerNamespaces($namespaces)
    {
        if (is_array($namespaces)) {
            foreach ($namespaces as $k => $v) {
                self::registerNamespace($k, $v);
            }
        } else {
            throw new \Exception('Invalid set of namespaces', 500);
        }
    }

    /**
     * @return array namespaces
     */
    public static function getNamespaces()
    {
        return self::$namespaces;
    }
}