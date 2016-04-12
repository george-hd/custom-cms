<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 21.11.2015 г.
 * Time: 12:19
 */

namespace Cms;


class Paths
{
    public static function root()
    {
        $root = explode('/', $_SERVER['PHP_SELF']);
        unset($root[count($root) - 1]);
        return implode('/', $root) . '/';
    }

    public static function link($link)
    {
        $link = explode('/', $link);
        foreach ($link as $v) {
            $parts[] = urlencode($v);
        }
        return self::root() . implode('/', $parts);
    }

    public static function action($action)
    {
        return self::root() . $action;
    }
}