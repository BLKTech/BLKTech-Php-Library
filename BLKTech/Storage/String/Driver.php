<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\Storage\String;

/**
 * Description of Driver
 *
 */
abstract class Driver implements \BLKTech\Storage\DriverInterface{
    
    public abstract function exists($id);
    public abstract function delete($id);
    public abstract function get($id);
    public abstract function set($string);
    
    
//    public abstract function spaceAvailable();  
//    public abstract function getUID();        
}
