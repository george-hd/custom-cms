<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 1.12.2015 г.
 * Time: 16:14
 */

namespace Cms\Models;


class BaseModel
{
    protected $errors = null;

    public function __construct()
    {
        $this->db = new \Cms\Database();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors($key, $value)
    {
        $this->errors[$key] = $value;
    }
}