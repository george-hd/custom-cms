<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 8.11.2015 г.
 * Time: 16:38
 */

namespace Cms\Routers;


class DefaultRouter implements IRouter
{
    /**
     * @return string $uri
     */
    public function getUri()
    {
        return urldecode($_GET['uri']);
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $_POST;
    }
}