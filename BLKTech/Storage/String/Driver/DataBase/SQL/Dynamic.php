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

namespace BLKTech\Storage\String\Driver\DataBase\SQL;
use BLKTech\DataBase\SQL\Driver\MySQL;
use BLKTech\DataType\Integer;
use BLKTech\DataBase\SQL\Driver\MySQL\Dynamic as MySQLDynamic;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
class Dynamic extends \BLKTech\Storage\String\Driver\DataBase\SQL
{
    const tableNamePrefix='blktech_storage_string__';

    private $driver;    
    private $dynamic;
    public function __construct(MySQL $driver)
    {
        $this->driver = $driver;
        $this->dynamic = new MySQLDynamic($driver, self::tableNamePrefix);
    }

    public function delete($id) 
    {
        return $this->dynamic->delete($id);
    }

    public function exists($id) 
    {
        return $this->dynamic->exists($id);
    }

    public function get($id) 
    {
        return $this->dynamic->get($id)['value'];
    }

    public function set($string) 
    {
        $idHigh = mb_strlen($string);        
                        
        $data = array(
            'value'=>$string
        );
        
        $this->createTable($idHigh);
        return $this->dynamic->set($idHigh, $data);
    }


    
    private function createTable($suffix)
    {
        $tableName = self::tableNamePrefix . $suffix;
                
        static $_ = null;
        
        if($_ === null)
            $_ = array();
        
        if(!isset($_[$tableName]))        
            $this->driver->command("CREATE TABLE IF NOT EXISTS `" . $_ . "` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, `value` char(" . $suffix . ") NOT NULL, PRIMARY KEY (id),UNIQUE (`value`)) ENGINE=MyISAM;");
        
        return $tableName;        
    }     
    
 
}
