<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\Storage\Path;
use BLKTech\DataType\Path;

/**
 * Description of Driver
 *
 */
abstract class Driver 
{
    public abstract function exists($id);
    public abstract function delete($id);
    public abstract function get($id);
    public abstract function set(Path $path);    
}
