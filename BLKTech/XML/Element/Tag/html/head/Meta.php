<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\XML\Element\Tag\HTML\head;
use \BLKTech\XML\Element\Tag;

/**
 * Description of Title
 *
 * @author instalacion
 */
class Meta extends Tag
{    
    parent::
    
    public function __construct($name, $value) 
    {
        parent::__construct();
        parent::setAttribute('name', $name);
        parent::setAttribute('value', $value);
    }
    
    public function setValue($value)
    {
        return parent::setAttribute('value', $value);
    }

    public function setName($name)
    {
        return parent::setAttribute('name', $name);
    }

    public function getValue()
    {
        return parent::getAttribute('value');
    }    
    
    public function getName()
    {
        return parent::getAttribute('name');
    }    
}