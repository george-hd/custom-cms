<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 12.11.2015 г.
 * Time: 10:48
 */

namespace Cms\Controllers;
use \Cms\App as app;
use Cms\Paths;
use Cms\View;
use \Cms\InputData as input;

abstract class BaseController
{
    /**
     * @var null
     */
    private $messages = null;
    protected $method = null;
    protected $input = null;

    public function __construct()
    {
        $this->onLoad();
        $this->method = \Cms\FrontController::getInstance()->getMethod();
        $this->input = input::getInstance();
        View::appendPage('messages', 'messages');
    }

    public function onLoad()
    {

    }

    public function countMessages() {
        return count($this->messages);
    }

    private function addMessage($message, $type, $field = null)
    {
        $app = app::getInstance();
        $this->messages[] = ['message' => $message, 'type' => $type, 'field' => $field];
        if($this->countMessages() > 0) {
            $app->getSession()->messages = $this->messages;
        }
    }

    public function addInfoMessage($message, $field = null)
    {
        $this->addMessage($message, 'info', $field);
    }

    public function addErrorMessage($message, $field = null) {
        $this->addMessage($message, 'error', $field);
    }

    public function redirect($target)
    {
        $target = str_replace('.', '/', $target);
        $target = Paths::root().$target;
        header("Location: {$target}");
    }
}