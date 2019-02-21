<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\XML;

/**
 * Description of Element
 *
 * @author instalacion
 */
abstract class Element {
    public abstract function toString($level);    
    public abstract function dump($level);

    public function __toString() 
    {
        return $this->toString(0);
    }
    
    protected function getTabs($level)
    {
        return str_pad('', $level, "\t");
    }

}
