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

class Integer 
{
    public static function unSignedInt32CombineIntoInt64($highInt32, $lowInt32)
    {
        return hexdec(str_pad(dechex($highInt32),8,'0',STR_PAD_LEFT) . str_pad(dechex($lowInt32),8,'0',STR_PAD_LEFT));
    }
    public static function unSignedInt64UnCombineIntoInt32($int64)
    {
        $int64 = dechex($int64);        
        return array(
            hexdec(substr($int64, 0, strlen($int64)-8)),
            hexdec(substr($int64,-8))
        );
    }        
}
