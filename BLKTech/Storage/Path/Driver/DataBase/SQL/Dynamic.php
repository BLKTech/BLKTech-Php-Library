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
    private function getTableNameHash($hash)
    {
        $_ = 'blktech_storage_path_hash__' . substr($hash, 0, 2);
        
        if($this->checkTable($_))
            $this->driver->command("CREATE TABLE IF NOT EXISTS `" . $_ . "` (`id` int(11) NOT NULL AUTO_INCREMENT, `idParent` int(11) NOT NULL, `level` int(11) NOT NULL, `hash` char(40) NOT NULL, PRIMARY KEY (id),UNIQUE (`hash`),UNIQUE (`idParent`,`level`)) ENGINE=MyISAM");
        
        return $_;
    }
    private function getTableNameNode($level)
    {
        $_ = 'blktech_storage_path_tree__' . $level;
        
        if($this->heckTable($_))
            $this->driver->command("CREATE TABLE IF NOT EXISTS `" . $_ . "` (`id` int(11) NOT NULL AUTO_INCREMENT, `idParent` int(11) NOT NULL, `idElement` int(11) NOT NULL, `lenElement` int(11) NOT NULL, PRIMARY KEY (id),UNIQUE (`idParent`,`idElement`,`lenElement`)) ENGINE=MyISAM");
        
        return $_;        
    }
    private function getTableNameElement($lenElement)
    {
        $_ = 'blktech_storage_path_element__' . $lenElement;
        
        if($this->checkTable($_))
            $this->driver->command("CREATE TABLE IF NOT EXISTS `" . $_ . "` (`id` int(11) NOT NULL AUTO_INCREMENT, `value` char(" . $lenElement . ") NOT NULL, PRIMARY KEY (id),UNIQUE (`value`)) ENGINE=MyISAM;");
        
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
        $row = $this->getHashData($id);

        if ($row === null)
            return null;

        $stringPath = '';

        $level = $row['level'];
        $idParent = $row['idParent'];
        while ($level >= 0)
        {
            $rowTree = $this->driver->getRow($this->getTableNameNode($level), array('idParent', 'idElement', 'lenElement'), array('id' => $idParent));

            $element = $this->driver->getText($this->getTableNameElement($rowTree['lenElement']), 'value', array('id' => $rowTree['idElement']));

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
            $idString = $this->string->set($element);
            
            $lenElement = strlen($element);        
            $idElement = array_shift($this->driver->autoTable($this->getTableNameElement($lenElement), array('value' => $element), array('id')));            
            $idParent = array_shift($this->driver->autoTable($this->getTableNameNode($level), array('idParent' => $idParent, 'idElement' => $idElement, 'lenElement' => $lenElement), array('id')));

            $level++;
        }

        $hash = $path->getHash(new Hash('SHA1'));

        $this->driver->autoInsert($this->getTableNameHash($hash), array('hash' => $hash, 'idParent' => $idParent, 'level' => $level - 1));

        return $hash;
    }
    public function getChilds($id)
    {
        $basePath = $this->getPathByHash($id);

        $row = $this->getHashData($id);

        if ($row === null)
            return null;

        $level = $row['level'];
        $idParent = $row['idParent'];

        $_ = array();

        foreach ($this->driver->select($this->getTableNameNode($level + 1), array('idElement', 'lenElement'), array('idParent' => $idParent)) as $row)
            $_[] = $basePath->getChild($this->driver->getText($this->getTableNameElement($row['lenElement']), 'value', array('id' => $row['idElement'])));

        return $_;
    }
    
}
