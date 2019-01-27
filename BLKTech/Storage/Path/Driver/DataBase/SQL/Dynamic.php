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

namespace BLKTech\Storage\Path\Driver\DataBase\SQL;
use BLKTech\DataBase\SQL\Driver\MySQL;
use BLKTech\DataType\Path;
use BLKTech\DataType\Integer;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
class Dynamic extends \BLKTech\Storage\Path\Driver\DataBase\SQL
{
    
    private $driver;    
    private $string;
    public function __construct(MySQL $driver)
    {
        $this->driver = $driver;
        $this->string = new \BLKTech\Storage\String\Driver\DataBase\SQL\Dynamic($driver);
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
    private function getTableNameNode($level)
    {
        $_ = 'blktech_storage_path__' . $level;
        
        if($this->checkTable($_))
            $this->driver->command("CREATE TABLE IF NOT EXISTS `" . $_ . "` (`id` int(11) NOT NULL AUTO_INCREMENT, `idParent` int(11) NOT NULL, `idElement` int(11) NOT NULL, `lenElement` int(11) NOT NULL, PRIMARY KEY (id),UNIQUE (`idParent`,`idElement`,`lenElement`)) ENGINE=MyISAM");
        
        return $_;        
    }
    private function getHashData($hash)
    {
        return $this->driver->getRow($this->getTableNameHash($hash), array('idParent', 'level'), array('hash' => $hash));
    }
    
    
    public function delete($id) 
    {
        throw new BLKTech\NotImplementedException();
    }

    public function exists($id) 
    {
        throw new BLKTech\NotImplementedException();
    }

    public function get($id) 
    {
        $row = Integer::unSignedInt64UnCombineIntoInt32($id);
        $stringPath = '';

        $level = $row[0];
        $idParent = $row[1];
        while ($level >= 0)
        {
            $rowTree = $this->driver->getRow($this->getTableNameNode($level), array('idParent', 'idElement', 'lenElement'), array('id' => $idParent));

            $element = $this->string->get(Integer::unSignedInt32CombineIntoInt64($rowTree['lenElement'], $rowTree['idElement']));
            
            $stringPath = $element . DIRECTORY_SEPARATOR . $stringPath;

            $idParent = $rowTree['idParent'];
            $level--;
        }

        return Path::getPathFromString($stringPath);        
    }
    public function set(Path $path) 
    {
        $level = 0;
        $idParent = 0;
        foreach ($path->getPathElements() as $element)
        {
            $idString = Integer::unSignedInt64UnCombineIntoInt32($this->string->set($element));
            $idParent = $this->driver->autoTable($this->getTableNameNode($level), array('idParent' => $idParent, 'idElement' => $idString[1], 'lenElement' => $idString[0]), array('id'))['id'];

            $level++;
        }

        return Integer::unSignedInt32CombineIntoInt64($level, $idParent);
    }
    public function getChilds($id)
    {
        $row = Integer::unSignedInt64UnCombineIntoInt32($id);


        $level = $row[0];
        $idParent = $row[1];

        $_ = array();

        foreach ($this->driver->select($this->getTableNameNode($level + 1), array('idElement', 'lenElement'), array('idParent' => $idParent)) as $row)
            $_[] = $this->string->get (Integer::unSignedInt32CombineIntoInt64 ($row['lenElement'], $row['idElement']));
                

        return $_;
    }
    
}