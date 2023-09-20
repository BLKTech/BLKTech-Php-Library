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

class Query extends HashTable
{
    private static function getFromGlobals()
    {
        $_ = new self();
        foreach($_GET as $key => $value) {
            $_->set(trim($key), $value);
        }
        return $_;
    }

    public static function getFromString($string)
    {
        $_ = new self();
        foreach (explode("&", $string) as $element) {
            $element = explode('=', $element, 2);

            if(count($element) == 2) {
                $value = urldecode(trim($element[1]));
            } else {
                $value = null;
            }

            $_->set(urldecode(trim($element[0])), $value);
        }
        return $_;
    }


    public function __toString()
    {
        $_ = '';
        foreach($this as $key => $value) {
            if($key == null) {
                continue;
            }

            if($_ != '') {
                $_ .= '&';
            }

            $_ .= urlencode($key);

            if($value !== null) {
                $_ .= '=' . urlencode($value);
            }

        }
        return $_;
    }
}
