<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\Storage\KeyValue;
use BLKTech\DataType\Service;
/**
 * Description of Driver
 *
 */
abstract class Driver {
    

    public abstract function exists($key);
    public abstract function delete($key);
    public abstract function get($key);
    public abstract function set($key,$data);
    
    
//    public abstract function spaceAvailable();  
//    public abstract function getUID();        
}
