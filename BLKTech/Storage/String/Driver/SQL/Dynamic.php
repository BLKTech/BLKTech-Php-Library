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
use BLKTech\DataType\Integer;
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

    public function delete($id) 
    {
        $_ = $this->getTableAndWhere($id);
        return $this->driver->delete($_['table'], $_['where']);        
    }

    public function exists($id) 
    {
        $_ = $this->getTableAndWhere($id);
        return $this->driver->exists($_['table'], $_['where']);
    }

    public function get($id) {
        $_ = $this->getTableAndWhere($id);
        return $this->driver->getText($_['table'], 'value', $_['where']);
    }

    public function set($string) 
    {
        $length = mb_strlen($string);
        $table = $this->getTableNameString($length);
        $id = array_pop($this->driver->autoTable($table, array('value'=>$string), array('id')));
        
        return Integer::unSignedInt32CombineIntoInt64($length, $id);
    }

    private function getTableAndWhere($id)
    {
        $_ = Integer::unSignedInt64UnCombineIntoInt32($id);                
        return array(
            'table'=>$this->getTableNameString(mb_strlen($_[0])),
            'where'=>array('id'=>$_[1])
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
    private function getTableNameString($length)
    {
        $_ = 'blktech_storage_string__' . $length;
        
        if($this->checkTable($_))
            $this->driver->command("CREATE TABLE IF NOT EXISTS `" . $_ . "` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, `value` char(" . $length . ") NOT NULL, PRIMARY KEY (id),UNIQUE (`value`)) ENGINE=MyISAM;");
        
        return $_;        
    }    
}
