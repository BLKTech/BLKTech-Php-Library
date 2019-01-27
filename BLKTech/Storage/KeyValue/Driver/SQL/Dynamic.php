<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\Storage\KeyValue\Driver\SQL;

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
    
    public function delete($id) 
    {
        
    }

    public function exists($id) 
    {
        
    }

    public function get($id) 
    {
        
    }

    public function set($id, $data) 
    {
        
    }

    private function getTableNameString($length)
    {
        $_ = 'blktech_storage_keyvalue__' . $length;
        
        if($this->checkTable($_))
            $this->driver->command("CREATE TABLE IF NOT EXISTS `" . $_ . "` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, `idKey` int(11) UNSIGNED NOT NULL, `idValue` int(11) UNSIGNED NOT NULL) NOT NULL, PRIMARY KEY (id),UNIQUE (`value`)) ENGINE=MyISAM;");
        
        return $_;        
    }    
}
