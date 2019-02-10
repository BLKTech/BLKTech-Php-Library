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
use \BLKTech\XML\Element;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
abstract class Tag extends Element
{
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
        echo parent::getTabs($level) . '<'. $this->name;
        
        foreach ($this->attributes as $attribute)
            echo $attribute;
        
        if(count($this->elements)==0)
            echo ' />'.PHP_EOL;
        else
        {
            echo '>'.PHP_EOL;
            
            foreach ($this->elements as $element)
                echo $element->toString ($level+1);
            
            echo parent::getTabs($level) . '</' . $this->name . ">".PHP_EOL;
        }        
    }

    public function toString($level) 
    {
        $_ = parent::getTabs($level) . '<'. $this->name;
        
        foreach ($this->attributes as $attribute)
            $_ .= ' ' . $attribute;
        
        if(count($this->elements)==0)
            $_ .= ' />'.PHP_EOL;
        else
        {
            $_ .= '>'.PHP_EOL;
            
            foreach ($this->elements as $element)
                $_ .= $element->toString ($level+1);
            
            $_ .= parent::getTabs($level) . '</' . $this->name . '>'.PHP_EOL;
        }
        
        return $_;
    }

}
