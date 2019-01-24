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

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
class Crypted
{
//    private $driver;
//    private $hash;
//    
//    public function __construct(Driver $driver,Hash $hash) 
//    {
//        $this->driver = $driver;
//        $this->hash = $hash;
//    }
//
//    private function checkHash($hashValue)
//    {
//        if(!$this->hash->checkHash($hashValue))
//            throw new InvalidHashValueException($hashValue);
//    }
//    
//    public function delete($hashValue) 
//    {
//        $this->checkHash($hashValue);
//        return $this->driver->exists($hashValue);
//    }
//
//    public function exists($hashValue) 
//    {
//        $this->checkHash($hashValue);
//        return $this->driver->exists($hashValue);
//    }
//
//    public function get($hashValue) 
//    {
//        $this->checkHash($hashValue);
//        $data = $this->driver->get($hashValue);
//        
//        if(!$this->hash->check($hashValue, $data))
//        {
//            $this->driver->delete($hashValue);
//            throw new CorruptedFileException($hashValue);
//        }
//        
//        return $data;
//    }
//
//    public function set($data) 
//    {
//        $hashValue = $this->hash->calc($data);
//        $this->driver->set($hashValue, $data);
//        return $hashValue;
//    }

}
