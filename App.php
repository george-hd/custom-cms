<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 6.11.2015 г.
 * Time: 18:57
 */
namespace Cms;
include_once 'Loader.php';

class App
{
    private static $instance = null;

    /** @var \Cms\Config */
    private $config = null;
    private $frontController;
    private $router = null;
    private $connections = null;
    /** @var \Cms\Session\ISession */
    private $session = null;
    private $appLanguage = null;

    /**
     * App constructor.
     */
    private function __construct()
    {
        \Cms\Loader::registerNamespace('Cms', dirname(__FILE__) . DIRECTORY_SEPARATOR);
        \Cms\Loader::registerAutoload();
        $this->config = \Cms\Config::getInstance();
        $this->frontController = \Cms\FrontController::getInstance();
    }

    /**
     * @throws \Exception
     * @return void
     */
    public function run()
    {
        if ($this->config->getConfigFolder() === null) {
            $this->config->setConfigFolder(dirname(__FILE__) . '/Config');
        }
        if ($this->router === null) {
            $this->router = new \Cms\Routers\DefaultRouter();
            $this->frontController->setRouter($this->router);
        }
        $sess = $this->getConfig()->app['session'];
        if($sess['autostart'] === true) {
            if($sess['type'] === 'native') {
                $s = new \Cms\Session\NativeSession($sess['name'], $sess['lifetime'], $sess['path'], $sess['domain'], $sess['secure']);
            }
            $this->setSession($s);
        }
        $this->setAppLanguage();
        $this->frontController->dispatch();
    }

    /**
     * @param Session\ISession $session
     */
    public function setSession(\Cms\Session\ISession $session)
    {
        $this->session = $session;
    }

    /**
     * @return Session\ISession
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return \Cms\Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param string $connection
     * @return \PDO
     * @throws \Exception
     */
    public function getDbConnection($connection = 'default')
    {
        if (!$connection) {
            throw new \Exception('Invalid db connection!', 500);
        }
        if ($this->connections[$connection]) {
            return $this->connections[$connection];
        } else {
            $dbParams = $this->getConfig()->database[$connection];
            if(!$dbParams) {
                throw new \Exception('Invalid db connection passed.', 500);
            }
            $con = new \PDO(
                $dbParams['connection_string'],
                $dbParams['user_name'],
                $dbParams['password']
            );
            $this->connections[$connection] = $con;
            return $con;
        }
    }

    /**
     * @return null
     */
    public function getsv($key)
    {
        $siteVar = \Cms\Repositories\SiteVarRepository::getInstance()->getsv($key, $this->getappLanguage());
        return $siteVar['value'];
    }

    /**
     * @return App
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new \Cms\App();
        }
        return self::$instance;
    }

    /**
     * @return null
     */
    public function getAppLanguage()
    {
        return $this->appLanguage;
    }

    public function setAppLanguage()
    {
        if(empty($_SESSION['appLanguage'])) {
            $this->appLanguage = \Cms\Repositories\LanguageRepository::getInstance()->getDefaultSiteLang();
            $this->getSession()->appLanguage = $this->appLanguage;
        } else {
            $this->appLanguage = $this->getSession()->appLanguage;
        }
    }

}