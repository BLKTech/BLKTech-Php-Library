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

namespace BLKTech\DesignPatterns;

/**
 * Singleton Pattern
 *
 * @author https://stackoverflow.com/questions/203336/creating-the-singleton-design-pattern-in-php5
 * @author TheKito < blankitoracing@gmail.com >
 */

abstract class Singleton
{
    private static $instances = array();
    protected function __construct() {}
    protected function __clone() {}
    public function __wakeup() 
    {
        throw new Exception("Cannot unserialize singleton");
    }

    public static function getInstance()
    {
        $cls = get_called_class(); // late-static-bound class name
        if (!isset(self::$instances[$cls])) 
            self::$instances[$cls] = new static;
        
        return self::$instances[$cls];
    }   
}
