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

use BLKTech\DataType\Integer;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Dynamic extends SubTable
{
    public function delete($id)
    {
        $id_ = Integer::unSignedInt64UnCombineIntoInt32($id);
        return $this->driver->delete(parent::getTable($id_[0], false), array('id'=>$id_[1]));
    }

    public function exists($id)
    {
        $id_ = Integer::unSignedInt64UnCombineIntoInt32($id);
        return $this->driver->exists(parent::getTable($id_[0], false), array('id'=>$id_[1]));
    }

    public function get($id)
    {
        $id_ = Integer::unSignedInt64UnCombineIntoInt32($id);
        return $this->driver->getRow(parent::getTable($id_[0], false), array(), array('id'=>$id_[1]));
    }

    public function set($idHigh, $data = array())
    {
        $idLow = $this->driver->autoTable(parent::getTable($idHigh, true), $data, array('id'))['id'];
        return Integer::unSignedInt32CombineIntoInt64(
            $idHigh,
            $idLow
        );
    }
}
