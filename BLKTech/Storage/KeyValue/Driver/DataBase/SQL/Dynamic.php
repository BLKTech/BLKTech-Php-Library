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

namespace BLKTech\Storage\KeyValue\Driver\DataBase\SQL;
use BLKTech\DataBase\SQL\Driver\MySQL;
use BLKTech\DataType\Integer;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
class Dynamic extends \BLKTech\Storage\KeyValue\Driver\DataBase\SQL{
    
    const tableNamePrefix='blktech_storage_keyvalue__';
    
    private $driver;    
    private $string;
    public function __construct(MySQL $driver)
    {
        $this->driver = $driver;
        $this->string = new \BLKTech\Storage\String\Driver\DataBase\SQL\Dynamic($driver);
    }
    
    public function delete($id) 
    {
        $_ = Integer::unSignedInt64UnCombineIntoInt32($id);
        return $this->driver->delete($this->getTableNameKeyValue($_[0]), array('id'=>$_[1]));    
    }

    public function exists($id) 
    {
        $_ = Integer::unSignedInt64UnCombineIntoInt32($id);
        return $this->driver->exists($this->getTableNameKeyValue($_[0]), array('id'=>$_[1]));
    }

    public function get($id) 
    {
        $_ = Integer::unSignedInt64UnCombineIntoInt32($id);
        $row_ = $this->driver->getRow($this->getTableNameKeyValue($_[0]), array('idKey','lenValue','idValue'),array('id'=>$_[1]));        
        return array(
            $this->string->get(Integer::unSignedInt32CombineIntoInt64($_[0], $row_['idKey'])),
            $this->string->get(Integer::unSignedInt32CombineIntoInt64($row_['lenValue'], $row_['idValue']))
        );
    }

    public function set($key, $value) 
    {
        $key_ = $this->string->set($key);
        $value_ = $this->string->set($value);
        
        $id = $this->driver->autoTable($this->getTableNameKeyValue($key_[0]), array('idKey'=>$key_[1],'lenValue'=>$value_[0],'idValue'=>$value_[1]), array('id'))['id'];
                        
        return Integer::unSignedInt32CombineIntoInt64($key_[0], $id);               
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
        $_ = self::tableNamePrefix . $length;
        
        if($this->checkTable($_))
            $this->driver->command("CREATE TABLE IF NOT EXISTS `" . $_ . "` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, `idKey` int(11) UNSIGNED NOT NULL, `lenValue` int(11) UNSIGNED NOT NULL, `idValue` int(11) UNSIGNED NOT NULL, PRIMARY KEY (id),INDEX (`idKey`)) ENGINE=MyISAM;");
        
        return $_;        
    }

    public function getKeys() 
    {
        $_ = array();
        foreach($this->driver->getTablesWithPrefix(self::tableNamePrefix) as $tableName)
        {
            $idKeyHigh = substr($tableName, strlen(self::tableNamePrefix));
            foreach ($this->driver->query('SELECT DISTINCT idKey FROM ' .$tableName) as $row)
            {
                $idKeyLow = $row['idKey'];
                $_ [] = $this->string->get(Integer::unSignedInt32CombineIntoInt64($idKeyHigh, $idKeyLow));
            }            
        }
        return $_;
    }

    public function getValues($key) 
    {
        $key_ = Integer::unSignedInt64UnCombineIntoInt32($this->string->set($key));
        
        $_ = array();        
        foreach($this->driver->select($this->getTableNameKeyValue($key_[0]), array('lenValue','idValue'), array('idKey'=>$key_[1])) as $row)
            $_[] = $this->string->get(Integer::unSignedInt32CombineIntoInt64($row['lenValue'], $row['idValue']));
        return $_;
    }

}
