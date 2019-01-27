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

namespace BLKTech\Storage\KeyValue\Driver\SQL;
use BLKTech\DataBase\SQL\Driver\MySQL;
use BLKTech\DataType\Integer;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
class Dynamic extends \BLKTech\Storage\KeyValue\Driver\SQL{
    
    private $driver;    
    private $string;
    public function __construct(MySQL $driver)
    {
        $this->driver = $driver;
        $this->string = new \BLKTech\Storage\String\Driver\SQL\Dynamic($driver);
    }
    
    public function delete($key) 
    {
        $_ = $this->getTableAndWhere($key);
        return $this->driver->delete($_['table'], $_['where']);        
    }

    public function exists($key) 
    {
        $_ = $this->getTableAndWhere($key);
        return $this->driver->exists($_['table'], $_['where']);
    }

    public function get($key) 
    {
        $_ = $this->getTableAndWhere($key);        
        return $this->string->get($this->driver->getText($_['table'], 'idValue', $_['where']));
    }

    public function set($key, $data) 
    {
        $_ = $this->getTableAndWhere($key);
        $this->driver->autoInsert($_['table'], array_merge($_['where'], array('idValue'=> $this->string->set($data))));
    }

    private function getTableAndWhere($key)
    {
        $_ = Integer::unSignedInt64UnCombineIntoInt32($this->string->set($key));                      
        return array(
            'table'=>$this->getTableNameKeyValue($_[0]),
            'where'=>array('idKey'=>$_[1])
        );
    }
    private function checkTable($tableName)
    {
        static $_ = null;
        
        if($_ === null)
            $_ = array();
        
        if(isset($_[$tableName]))
            return false;
        else
        {
            $_[$tableName] = true;
            return true;
        }
    }      
    private function getTableNameKeyValue($length)
    {
        $_ = 'blktech_storage_keyvalue__' . $length;
        
        if($this->checkTable($_))
            $this->driver->command("CREATE TABLE IF NOT EXISTS `" . $_ . "` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, `idKey` int(11) UNSIGNED NOT NULL, `idValue` bigint(20) UNSIGNED NOT NULL, PRIMARY KEY (id),INDEX (`idKey`)) ENGINE=MyISAM;");
        
        return $_;        
    }    
}
