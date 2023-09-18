<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\Storage\Link;

/**
 * Description of Driver
 *
 * @author instalacion
 */

abstract class Driver implements \BLKTech\Storage\DriverInterface
{
    abstract public function delete($id);
    abstract public function exists($id);
    abstract public function get($id);
    abstract public function set($idSource, $idDestination);

}
