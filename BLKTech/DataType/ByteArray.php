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
    public static function fromNumber(int $number)
    {
        $_ = array();
        foreach (str_split(hex2bin(dechex($number))) as $byte)
            $_[] = hexdec (bin2hex ($byte));
        
        return $_;
    }
    
    public static function toNumber(array $bytes)
    {
        $hex = '';
        foreach ($bytes as $byte)        
            $hex .= str_pad(dechex($byte), 2, 0, STR_PAD_LEFT); 
        
        return hexdec(hexdec($hex));

    }    
}
