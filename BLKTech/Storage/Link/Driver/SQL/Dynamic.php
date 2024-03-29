<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\Storage\Link\Driver\SQL;

use BLKTech\DataType\Integer;
use BLKTech\DataBase\SQL\Driver\MySQL;
use BLKTech\DataBase\SQL\Driver\MySQL\Dynamic as MySQLDynamic;

/**
 * Description of Dynamic
 *
 * @author instalacion
 */
class Dynamic extends \BLKTech\Storage\Link\Driver\SQL
{
    public const tableNamePrefix = 'blktech_storage_link__';

    private $driver;
    private $dynamic;
    public function __construct(MySQL $driver)
    {
        $this->driver = $driver;
        $this->dynamic = new MySQLDynamic($driver, $this::tableNamePrefix);
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
        $id_ = Integer::unSignedInt64UnCombineIntoInt32($id);
        $row = $this->dynamic->get($id);
        return Integer::unSignedInt32CombineIntoInt64($row['idDestinationHigh'], $row['idDestinationLow']);
    }

    public function set($idSource, $idDestination)
    {
        $idSource_ = Integer::unSignedInt64UnCombineIntoInt32($idSource);
        $idDestination_ = Integer::unSignedInt64UnCombineIntoInt32($idDestination);

        $data = array(
                'idSourceLow' => $idSource_[1],
                'idDestinationHigh' => $idDestination_[0],
                'idDestinationLow' => $idDestination_[1]
            );

        $this->createTable($idSource_[0]);
        return $this->dynamic->set($idSource_[0], $data);
    }

    private function createTable($suffix)
    {
        if($this->dynamic->checkTable($suffix)) {
            return;
        }

        $_[$tableName] = $this->driver->command("CREATE TABLE IF NOT EXISTS `" . self::tableNamePrefix . $suffix . "` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, `idSourceLow` int(11) UNSIGNED NOT NULL, `idDestinationHigh` int(11) UNSIGNED NOT NULL, `idDestinationLow` int(11) UNSIGNED NOT NULL, PRIMARY KEY (id),INDEX (`idSourceLow`)) ENGINE=MyISAM;");

    }
}
