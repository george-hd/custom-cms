<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 8.11.2015 г.
 * Time: 20:06
 */

namespace Cms;

class Config
{
    private static $instance = null;
    private $configFolder = null;
    private $configArray = array();

    /**
     * Config constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string configFolder
     */
    public function getConfigFolder()
    {
        return $this->configFolder;
    }

    /**
     * @param $configFolder
     * @throws \Exception
     */
    public function setConfigFolder($configFolder)
    {
        $configFolder = realpath(trim($configFolder));
        if($configFolder && is_readable($configFolder) && is_dir($configFolder)) {
            $this->configArray = array();
            $this->configFolder = $configFolder . DIRECTORY_SEPARATOR;
            $ns = $this->app['namespace'];
            if(is_array($ns)) {
                \Cms\Loader::registerNamespaces($ns);
            } else {
                throw new \Exception('Invalid config directory', 500);
            }
        } else {
            throw new \ErrorException('\'Invalid config directory.', 500);
        }
    }

    /**
     * @param string $path
     * @throws \Exception
     */
    public function includeConfigFile($path) {
        if (!$path) {
            //TODO
            throw new \Exception;
        }
        $file = realpath($path);
        if ($file != FALSE && is_file($file) && is_readable($file)) {
            $_basename = explode('.php', basename($file))[0];
            $this->configArray[$_basename]=include $file;
        } else {
            //TODO
            throw new \Exception('Config file read error:' . $path);
        }
    }

    /**
     * @param $name
     * @return $this->configArray[$name] | null
     * @throws \Exception
     */
    public function __get($name) {
        if (!$this->configArray[$name]) {
            $this->includeConfigFile($this->configFolder . $name . '.php');
        }
        if (array_key_exists($name, $this->configArray)) {
            return $this->configArray[$name];
        }
        return null;
    }

    /**
     * @return \Cms\Config
     */
    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new \Cms\Config();
        }
        return self::$instance;
    }
}