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

namespace BLKTech\Storage\KeyValue\Driver\Memory;
use \BLKTech\DataType\Service;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
class Memcached extends \BLKTech\Storage\KeyValue\Driver\Memory{
    
    public static function getLocalHost()
    {
        return new Memcached(new Service('127.0.0.1', 11211));
    }
    
    private $memcached;
        
    function __construct(Service $server)
    {
        $this->memcached = new \Memcached();        
        $this->memcached->addServer($server->getHost(),$server->getPort());                
    }

    
    public function delete($key) 
    {
        return $this->memcached->delete($key);
    }

    public function exists($key) 
    {
        return $this->memcached->get($key)!==FALSE;
    }

    public function get($key) 
    {
        return $this->memcached->get($key);
    }

    public function set($key, $data) 
    {
        return $this->memcached->set($key, $data);
    }

    public function getKeys() 
    {
        throw new \BLKTech\NotImplementedException();       
    }

    public function getValues($key) 
    {
        throw new \BLKTech\NotImplementedException();        
    }

}
