<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 15.11.2015 г.
 * Time: 17:24
 */

namespace Cms\ViewHelpers;


class Form
{
    private $output = '';

    /**
     * @return \Cms\ViewHelpers\Form
     */
    public static function create()
    {
        return new self;
    }

    /**
     * @return \Cms\ViewHelpers\Form
     */
    public function openForm()
    {
        $this->output .= '<form ';
        return $this;
    }

    /**
     * @param  array $attributes
     * @return \Cms\ViewHelpers\Form
     * @throws \Exception
     */
    public function addAttributes($attributes)
    {
        if(!is_array($attributes)) {
            throw new \Exception('$attributes must be an array!', 500);
        } else {
            foreach ($attributes as $k => $v) {
                $this->output .= $k . '="' . $v . '" ';
            }
            $this->output .= '>';
        }
        return $this;
    }

    /**
     * @param string $labelValue
     * @param array $attributes
     * @return \Cms\ViewHelpers\Form
     * @throws \Exception
     */
    public function addLabel($labelValue, $attributes = array())
    {
        $this->output .= '<label ';
        $this->addAttributes($attributes);
        $this->output .= $labelValue . '</label>';
        return $this;
    }

    /**
     * @param array $attributes
     * @return \Cms\ViewHelpers\Form
     * @throws \Exception
     */
    public function addField($attributes = array())
    {
        $this->output .= '<input ';
        $this->addAttributes($attributes);
        return $this;
    }

    /**
     * @param array $attributes
     * @param $errors
     * @return $this
     * @throws \Exception
     */
    public function addFieldWithErrors($attributes = array(), $errors = null)
    {
        $this->output .= '<input ';
        $this->addAttributes($attributes);
        if(is_array($errors)) {
            foreach ($errors as $error) {
                $this->output .= '<p>' . $error . '</p>';
            }
        } else {
            $this->output .= '<p>' . $errors . '</p>';
        }
        return $this;
    }

    /**
     * @param string $value
     * @param array $attributes
     * @return \Cms\ViewHelpers\Form
     * @throws \Exception
     */
    public function addButton($value, $attributes = array())
    {
        $this->output .= '<button ';
        $this->addAttributes($attributes);
        $this->output .= $value;
        $this->output .= '</button>';
        return $this;
    }

    public function render()
    {
        //TODO ForgeryToken can't be set to false!!!
        $this->addField(array('name' => '___ft', 'type' => 'hidden', 'value' => ''));
        $this->output .= '</form>';
        echo $this->output;
    }
}