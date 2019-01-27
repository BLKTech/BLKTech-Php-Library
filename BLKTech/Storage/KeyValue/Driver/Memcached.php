<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\Storage\KeyValue\Driver;

/**
 * Description of Memcached
 *
 * @author instalacion
 */
class Memcached extends \BLKTech\Storage\KeyValue\Driver{
    
    private $memcached;
    function __construct($servers = array('127.0.0.1')) 
    {
        $this->memcached = new \Memcache();
        
        foreach ($servers as $server)
            $this->memcached->addServer($server);                
    }

    
    public function delete($key) 
    {
        return $this->delete($key);
    }

    public function exists($key) 
    {
        return $this->exists($key);
    }

    public function get($key) 
    {
        return $this->get($key);
    }

    public function set($key, $data) 
    {
        return $this->memcached->set($key, $data);
    }

}
