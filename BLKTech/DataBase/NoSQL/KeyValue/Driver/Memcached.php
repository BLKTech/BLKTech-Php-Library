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

namespace BLKTech\DataBase\NoSQL\KeyValue\Driver;
use \BLKTech\DataType\Service;
use \BLKTech\Cryptography\Hash;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
class Memcached extends \BLKTech\DataBase\NoSQL\KeyValue\Driver{
    
    public static function getLocalHost($keyPrefix = NULL, Hash $hashAlgorithm = null)
    {
        return new Memcached(new Service('127.0.0.1', 11211), $keyPrefix, $hashAlgorithm);
    }
    
    private $memcached;
    private $keyPrefix;
    private $hashAlgorithm;
        
    public function __construct(Service $server, $keyPrefix = NULL, Hash $hashAlgorithm = null)
    {
        $this->memcached = new \Memcached();        
        $this->memcached->addServer($server->getHost(),$server->getPort());                         
        $this->keyPrefix = $keyPrefix;
        $this->hashAlgorithm = $hashAlgorithm;
        
        if($this->keyPrefix===NULL)        
            $this->keyPrefix = abs(crc32($_SERVER['SCRIPT_FILENAME']));                
    }

    private function mapKey($key)
    {
        if($this->hashAlgorithm!==NULL)
            return $this->hashAlgorithm->calc($this->keyPrefix.$key);
        else
            return $this->keyPrefix.$key;
    }
    
    public function delete($key) 
    {
        return $this->memcached->delete($this->mapKey($key));
    }

    public function exists($key) 
    {
        return $this->memcached->get($this->mapKey($key))!==FALSE;
    }

    public function get($key) 
    {
        return $this->memcached->get($this->mapKey($key));
    }

    public function set($key, $data) 
    {
        return $this->memcached->set($this->mapKey($key), $data);
    }

    public function getKeys() 
    {
        if($this->hashAlgorithm!==NULL)
            HashedKeysException::throwException('Hashed with: ' . $this->hashAlgorithm->getName());
        
        $keyPrefixLen = strlen($this->keyPrefix);
        
        $_ = array();
        
        foreach ($this->memcached->getAllKeys() as $key)
            if(substr($key, 0, $keyPrefixLen) == $this->keyPrefix)
                $_[] = substr ($key, $this->keyPrefix, $keyPrefixLen);
            
        return $_;
    }



}
