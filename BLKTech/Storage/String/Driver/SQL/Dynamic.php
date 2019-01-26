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

namespace BLKTech\Storage\String\Driver\SQL;
use BLKTech\DataBase\SQL\Driver\MySQL;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
class Dynamic extends \BLKTech\Storage\String\Driver\SQL
{
    
    private $driver;    
    public function __construct(MySQL $driver)
    {
        $this->driver = $driver;
    }

    public function delete($id) {
        
    }

    public function exists($id) {
        
    }

    public function get($id) {
        
    }

    public function set($string) 
    {
        $length = mb_strlen($string);
        $table = $this->getTableNameString($length);
        $this->driver->
                
                
    }

    
    private function getTableNameString($length)
    {
        $_ = 'blktech_storage_string__' . $length;
        
        if($this->checkTable($_))
            $this->driver->command("CREATE TABLE IF NOT EXISTS `" . $_ . "` (`id` int(11) NOT NULL AUTO_INCREMENT, `value` char(" . $length . ") NOT NULL, PRIMARY KEY (id),UNIQUE (`value`)) ENGINE=MyISAM;");
        
        return $_;        
    }    
}
