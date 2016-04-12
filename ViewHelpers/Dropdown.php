<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 15.11.2015 г.
 * Time: 13:38
 */

namespace Cms\ViewHelpers;


class Dropdown
{
    private $output = '';
    private $attributes = array();
    private $options = array();

    public static function create()
    {
        return new self;
    }


    public function setAttribute($k, $v)
    {
        $this->attributes[$k] = $v;
        return $this;
    }

    public function setAttributes($attributes)
    {
        if(!is_array($attributes)) {
            throw new \Exception('Parameters attributes must be an array!');
        } else {
            foreach ($attributes as $k => $v) {
                $this->setAttribute($k, $v);
            }
        }
        return $this;
    }

    public function setOption($option, $valKey ,$selected = null)
    {
        $this->options[$option] = '<option value="'.$valKey.'"'.' '.$selected.'>'.$option.'</option>';
        return $this;
    }

    public function render()
    {
        $this->output .= '<select ';
        foreach ($this->attributes as $k => $v) {
            $this->output .= $k . '="' . $v . '" ';
        }
        $this->output .= '>';
        foreach ($this->options as $option) {
            $this->output .= "\n\t" . $option;
        }
        $this->output .= "\n" . '</select>';
        echo $this->output;
    }
}
