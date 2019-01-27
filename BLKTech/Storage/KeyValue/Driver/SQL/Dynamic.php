<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\Storage\KeyValue\Driver\SQL;
use BLKTech\DataBase\SQL\Driver\MySQL;
use BLKTech\DataType\Integer;

/**
 * Description of Dynamic
 *
 * @author instalacion
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
