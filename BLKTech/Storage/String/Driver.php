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
abstract class Driver implements \BLKTech\Storage\DriverInterface
{
    abstract public function exists($id);
    abstract public function delete($id);
    abstract public function get($id);
    abstract public function set($string);


    //    public abstract function spaceAvailable();
    //    public abstract function getUID();
}
