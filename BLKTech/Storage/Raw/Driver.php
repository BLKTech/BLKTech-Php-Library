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

namespace BLKTech\Storage\Raw;
use BLKTech\Cryptography\Hash;
use BLKTech\Storage\Raw\Exception\CorruptedFileException;
/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
abstract class Driver implements \BLKTech\Storage\DriverInterface
{
    public abstract function exists($id);
    public abstract function delete($id);
    public abstract function get($id);
    public abstract function set($id,$data);
    public abstract function spaceAvailable();  
    public abstract function getUID();
    
    public function hashSet(Hash $hash, $data)
    {
        $hashValue = $hash->calc($data);
        $this->set($hashValue, $data);
        return $hashValue;
    }    
    public function hashGet(Hash $hash, $hashValue)
    {
        $hash->validateHash($hashValue);
        
        $data = $this->get($hashValue);
        
        if(!$hash->check($hashValue, $data))
        {
            $this->delete($hashValue);
            throw new CorruptedFileException($hashValue);
        }       
        
        return $data;
    }    
    public function hashDelete(Hash $hash, $hashValue) 
    {
        $hash->validateHash($hashValue);
        return $this->delete($hashValue);
    }
    public function hashExists(Hash $hash, $hashValue) 
    {
        $hash->validateHash($hashValue);
        return $this->exists($hashValue);
    }
    
}
