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

namespace BLKTech\DataType;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class HashTable implements \Iterator
{
    public static function getHashTableFromArray($array)
    {
        return new HashTable($array);
    }

    private $_;
    public function __construct($array = array())
    {
        if(!is_array($array)) {
            throw new InvalidArrayException($array);
        }

        $this->_= $array;
    }

    public function get($key, $default = null)
    {
        return isset($this->_[$key]) ? $this->_[$key] : $default;
    }
    public function set($key, $value)
    {
        $this->_[$key] = $value;
        return $this;
    }
    public function remove($key)
    {
        if(isset($this->_[$key])) {
            unset($this->_[$key]);
        }
    }
    public function exists($key)
    {
        return isset($this->_[$key]);
    }
    public function count()
    {
        return count($this->_);
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->_);
    }
    public function current()
    {
        return current($this->_);
    }
    public function key()
    {
        return key($this->_);
    }
    public function next()
    {
        next($this->_);
    }
    public function rewind()
    {
        reset($this->_);
    }
    public function valid()
    {
        return $this->key()!==null;
    }

}
