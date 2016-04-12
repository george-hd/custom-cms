<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 18.11.2015 г.
 * Time: 12:11
 */

namespace Cms\ViewHelpers;


class Grid
{
    private $output = '';
    private $source = null;
    private $columnNames = array();
    private $attributes = [];
    private $tdOptions = [];
    
    public function create($source)
    {
        if(is_array($source)) {
            $this->source = $source;
//            $this->setColumnNames();
        } else if(is_object($source)) {
            $this->source = (array)$source;
        } else {
            throw new \Exception('Invalid Grid data.', 500);
        }
        return $this;
    }
    
    public function setColumnNames($columnNames)
    {
        if(!is_array($columnNames)) {
            throw new \Exception('Column names must be an Array', 500);
        } else {
            foreach ($columnNames as $k => $v) {
                $this->columnNames[$k] = $v;
            }
        }
//        if(is_array($this->source[0])) {
//            foreach ($this->source[0] as $k => $v) {
//                $this->columnNames[] = $k;
//            }
//        }
//        if(is_object($this->source[0])) {
//            $refc = new \ReflectionClass($this->source[0]);
//            $props = $refc->getProperties();
//            foreach ($props as $prop) {
//                $prop->setAccessible(true);
//                $this->columnNames[] = $prop->name;
//            }
//        }
        return $this;
    }

    public function setAttributes($attributes = array()) {
        if(!is_array($attributes)) {
            throw new \Exception('Attributes passed to grid must be an array!', 400);
        }
        foreach ($attributes as $k => $v) {
            $this->attributes[$k] = $v;
        }
        return $this;
    }

    public function setTdClasses ($attr = []) {
        if(!is_array($attr)) {
            throw new \Exception('Attributes passed to setTdClass must be an array!', 400);
        }
        foreach ($attr as $k => $v) {
            $this->tdOptions[$k] = $v;
        }
        return $this;
    }

    public function render()
    {
        $this->output .= '<table ';
        foreach ($this->attributes as $k => $v) {
            $this->output .= $k .'="'. $v .'" ';
        }
        $this->output .= '>';
        $this->output .= "\n\t" . '<thead>'. "\n\t\t" . '<tr>';
        foreach ($this->columnNames as $name) {
            $this->output .= "\n\t\t\t" . '<th>' . $name . '</th>';
        }
        $this->output .= "\n\t\t" . '</tr>' . "\n" . '</thead>';
        $this->output .= "\n\t" . '<tbody>';
        foreach ($this->source as $result) {
            if(!is_array($result)) {
                $result = (array)$result;
            }
            $this->output .= "\n\t\t" . '<tr>';
            foreach ($result as $k => $v) {
                if($this->tdOptions[$k]) {
                    $this->output .= "\n\t\t\t" . '<td class="'.$this->tdOptions[$k].'">' . $v . '</td>';
                } else {
                    $this->output .= "\n\t\t\t" . '<td>' . $v . '</td>';
                }
            }
            $this->output .= "\n\t\t" . '</tr>';
        }
        $this->output .= "\n\t" . '</tbody>' . "\n" . '</table>';
        echo $this->output;
    }

    private function getDataFromArray($arr)
    {
        foreach ($arr as $k => $v) {
            $this->output .= "\n\t\t\t" . '<td>' . $v . '</td>';
        }
    }

}