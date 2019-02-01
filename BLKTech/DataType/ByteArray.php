<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\DataType;

/**
 * Description of Byte
 *
 * @author instalacion
 */
class ByteArray 
{
    public static function fromInt(int $number)
    {
        return unpack("C*", pack("L", $number));
    }
    
    public static function toLong(array $number)
    {
        return unpack("L",pack("C*",$number[3],$number[2],$number[1],$number[0]));
    }    
}
