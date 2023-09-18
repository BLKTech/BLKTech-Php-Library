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

namespace BLKTech\HTTP;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Header extends \BLKTech\DataType\HashTable
{
    public static function getFromGlobals()
    {
        $_ = new self();
        foreach($_SERVER as $key => $value) {
            $nkey = strtolower(trim($key));

            if(strpos($nkey, 'http_')===0) {
                $_->set(substr($nkey, strlen('http_')), $value);
            }
        }
        return $_;
    }

    public static function getFromString($string)
    {
        $_ = new self();
        foreach (explode("\n", str_replace("\r", "\n", $string)) as $line) {
            $line = explode(':', $line, 2);
            if(count($line)==2) {
                $_->set(trim($line[0]), trim($line[1]));
            }
        }
        return $_;
    }

    public function getList()
    {
        $_ = array();
        foreach ($this as $key => $value) {
            $_[] = $key . ': ' . $value;
        }
        return $_;
    }


    public function __toString()
    {
        return parent::getString(': ', "\n\r");
    }
}
