<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\DataType;

/**
 * Description of String
 *
 * @author instalacion
 */
class String 
{
    public static function isBinary($str) 
    {
        return preg_match('~[^\x20-\x7E\t\r\n]~', $str) > 0;
    }
}
