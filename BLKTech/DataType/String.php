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
    public static function toCamelCase($string)
    {
      $result = strtolower($string);

      preg_match_all('/_[a-z]/', $result, $matches);
      foreach($matches[0] as $match)
      {
          $c = str_replace('_', '', strtoupper($match));
          $result = str_replace($match, $c, $result);
      }
      return $result;
    }
    
}
