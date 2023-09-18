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

namespace BLKTech\Storage\KeyValue\Driver\Memory;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Program extends \BLKTech\Storage\KeyValue\Driver\Memory
{
    private $keys = array();
    private $values = array();

    public function delete($id)
    {
        $id_ = \BLKTech\DataType\Integer::unSignedInt64UnCombineIntoInt32($id);
        unset($this->values[$id_[1]]);
    }

    public function exists($id)
    {
        $id_ = \BLKTech\DataType\Integer::unSignedInt64UnCombineIntoInt32($id);
        return isset($this->keys[$id_[0]]) && isset($this->values[$id_[1]]);
    }

    public function get($id)
    {
        $id_ = \BLKTech\DataType\Integer::unSignedInt64UnCombineIntoInt32($id);
        return array(
            $this->keys[$id_[0]],
            $this->values[$id_[1]]
        );
    }

    public function set($key, $value)
    {
        if(!in_array($key, $this->keys)) {
            $this->keys[] = $key;
        }

        if(!in_array($value, $this->values)) {
            $this->values[] = $value;
        }

        return \BLKTech\DataType\Integer::unSignedInt32CombineIntoInt64(array_search($key, $this->keys), array_search($value, $this->values));
    }

    public function getKeys()
    {
        return $this->keys;
    }

    public function getValues($key)
    {
        throw new \BLKTech\NotImplementedException();
    }

}
