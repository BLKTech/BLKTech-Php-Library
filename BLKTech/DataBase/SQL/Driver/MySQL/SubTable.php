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

namespace BLKTech\DataBase\SQL\Driver\MySQL;
use \BLKTech\DataBase\SQL\Driver\MySQL;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class SubTable 
{    
    private static function clearTableName($tableName){return strtoupper(preg_replace("/[^A-Za-z0-9_]/", '', $tableName));}
    
    protected $driver;
    protected $tablePrefix;
    protected $suffixes = array();
    
    public function __construct(MySQL $driver,$tablePrefix) 
    {
        $this->driver = $driver;
        $this->tablePrefix = strtolower(self::clearTableName($tablePrefix));

        foreach($driver->getTablesWithPrefix($tablePrefix) as $table)        
            $this->suffixes[] = substr ($table, strlen ($this->tablePrefix));        
    }
    
    function getSuffixes() 
    {
        return $this->suffixes;
    }

    public function checkTable($suffix) 
    {
        return in_array(self::clearTableName($suffix), $this->tables);     
    }    
    
    public function getTable($suffix, $create = true)
    {       
        $suffix = self::clearTableName($suffix);
        
        $destinationTable = $this->tablePrefix . '__' . $suffix;
        
        if($create && !$this->checkTable($suffix));
            if($this->driver->copyTable($this->tablePrefix, $destinationTable))
                $this->suffixes[] = $suffix;
        
        return $destinationTable;                
    }
    

}