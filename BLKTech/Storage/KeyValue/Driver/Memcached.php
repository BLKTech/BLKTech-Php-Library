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

namespace BLKTech\Storage\KeyValue\Driver;
use \BLKTech\DataType\Service;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
class Memcached extends \BLKTech\Storage\KeyValue\Driver{
    
    private $memcached;
        
    function __construct(Service $server)
    {
        $this->memcached = new \Memcached();        
        $this->memcached->addServer($server->getHost(),$server->getPort());                
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
