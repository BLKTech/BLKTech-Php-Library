<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\Storage\Hash\Driver\SQL;

use BLKTech\Cryptography\Hash;
use BLKTech\DataBase\SQL\Driver\MySQL;
use BLKTech\DataBase\SQL\Driver\MySQL\Dynamic as MySQLDynamic;

/**
 * Description of Dynamic
 *
 * @author instalacion
 */
class Dynamic extends \BLKTech\Storage\Hash\Driver\SQL
{
    private $tableNamePrefix = 'blktech_storage_hash__';
    private $driver;
    private $dynamic;

    public function __construct(Hash $hash, MySQL $driver)
    {
        parent::__construct($hash);
        $this->tableNamePrefix = 'blktech_storage_'.$hash->getName().'__';
        $this->dynamic = new MySQLDynamic($driver, $this->tableNamePrefix);
        $this->driver = $driver;
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
        return $this->dynamic->get($id)['value'];
    }

    public function set($hash)
    {
        $idHigh = hexdec(substr($hash, 0, 7));
        $hash = substr($hash, 7);
        $this->createTable($idHigh, strlen($hash));

        $data = array(
            'value' => $hash
        );


        return $this->dynamic->set($idHigh, $data);
    }



    private function createTable($suffix, $len)
    {
        if($this->dynamic->checkTable($suffix)) {
            return;
        }

        $this->driver->command("CREATE TABLE IF NOT EXISTS `" . $this->tableNamePrefix . $suffix . "` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, `value` char(" . $len. ") NOT NULL, PRIMARY KEY (id),UNIQUE (`value`)) ENGINE=MyISAM;");
    }


}
