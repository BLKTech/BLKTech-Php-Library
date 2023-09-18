<?php
/*
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 */

namespace BLKTech\XML\Element;

use BLKTech\XML\Element;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

abstract class Tag extends Element
{
    public static function open($name, $attributes = array(), $close = true)
    {
        $_ = '<' . $name;

        foreach ($attributes as $key => $value) {
            $_ .= ' ' . $key;
            if($value!==null) {
                $_ .= '="' . str_replace('"', '&quot;', $value) . '"';
            }
        }

        if($close) {
            return $_ . '/>';
        } else {
            return $_ . '>';
        }
    }
    public static function close($name)
    {
        return '</' . $name . '>';
    }






    private $name;
    private $elements = array();
    private $attributes = array();

    public function __construct()
    {
        $this->name = strtolower((new \ReflectionClass($this))->getShortName());
    }
    public function addElement(Element $element)
    {
        $this->elements[] = $element;
    }
    public function dump($level)
    {
        $tabs = parent::getTabs($level);

        if(count($this->elements)==0) {
            echo $tabs . self::open($this->name, $this->attributes, true);
            return;
        }

        echo $tabs . self::open($this->name, $this->attributes, false) . PHP_EOL;

        foreach ($this->elements as $element) {
            $element->dump($level+1);
        }

        echo $tabs . self::close($this->name) . PHP_EOL;
    }
    public function toString($level)
    {
        $tabs = parent::getTabs($level);

        if(count($this->elements)==0) {
            return $tabs . self::open($this->name, $this->attributes, true);
        }

        $_ = $tabs . self::open($this->name, $this->attributes, false) . PHP_EOL;

        foreach ($this->elements as $element) {
            $_ .= $element->toString($level+1);
        }

        return $_ . $tabs . self::close($this->name) . PHP_EOL;
    }


    public function setAttribute($name, $value)
    {
        $this->attributes[strtolower($name)] = $value;
    }
    public function getAttribute($name)
    {
        return $this->attributes[strtolower($name)];
    }
}
