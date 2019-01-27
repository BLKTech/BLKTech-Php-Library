<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\Storage\Link\Driver\DataBase\SQL;
use BLKTech\DataType\Integer;

/**
 * Description of Dynamic
 *
 * @author instalacion
 */
class Dynamic extends \BLKTech\Storage\Link\Driver\DataBase\SQL{
    
    const tableNamePrefix='blktech_storage_link__';
    
    private $driver;    
    public function __construct(MySQL $driver)
    {
        $this->driver = $driver;
    }    
    
    public function delete($id) 
    {
        $id_ = Integer::unSignedInt64UnCombineIntoInt32($id);
    }

    public function exists($id) 
    {
        $id_ = Integer::unSignedInt64UnCombineIntoInt32($id);
    }

    public function get($id) 
    {
        $id_ = Integer::unSignedInt64UnCombineIntoInt32($id);

    }

    public function set($idSource, $idDestination) 
    {
        $idSource_ = Integer::unSignedInt64UnCombineIntoInt32($idSource);
        $idDestination_ = Integer::unSignedInt64UnCombineIntoInt32($idDestination);
    }

}
