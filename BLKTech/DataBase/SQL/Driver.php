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

namespace BLKTech\DataBase\SQL;

use BLKTech\DataBase\SQL\Exception\InsertException;
use BLKTech\DataBase\SQL\Exception\TooManyRowsException;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

abstract class Driver
{
    abstract public function isConnected();
    abstract public function query($query);
    abstract public function command($command);

    abstract public function delete($table, $where = array(), $limit = 100);
    abstract public function insert($table, $data = array());
    abstract public function update($table, $data, $where = array(), $limit = 0);
    abstract public function select($table, $column = array(), $where = array(), $limit = 100, $rand = false);

    abstract public function count($table, $where = array());
    abstract public function max($table, $column, $where = array());
    abstract public function min($table, $column, $where = array());

    abstract public function getTables();
    abstract public function getDatabases();
    abstract public function getDatabase();

    abstract public function copyTable($sourceTable, $destinationTable);

    final public function getArray($table, $column, $where = array())
    {
        $r = array();

        foreach ($this->select($table, array($column), $where) as $ROW) {
            array_push($r, $ROW[$column]);
        }

        return $r;
    }
    final public function getHashMap($table, $columnKey, $columnValue, $where = array())
    {
        $r = array();

        foreach ($this->select($table, array($columnKey, $columnValue), $where) as $ROW) {
            $r[$ROW[$columnKey]] = $ROW[$columnValue];
        }

        return $r;
    }
    final public function getRow($table, $column = array(), $where = array())
    {
        $RS = $this->select($table, $column, $where, 2);

        if (count($RS) > 1) {
            throw new TooManyRowsException();
        }

        if (count($RS) == 0) {
            return null;
        }

        return $RS[0];
    }
    final public function getText($table, $column, $where = array())
    {
        $ROW = $this->getRow($table, array($column), $where);

        if ($ROW == null) {
            return null;
        }

        return $ROW[$column];
    }

    final public function autoTable($table, $data, $column = array(), $create = true)
    {
        $rs = $this->select($table, $column, $data, 1);

        if (count($rs) > 0) {
            return $rs[0];
        } elseif ($create) {
            if ($this->insert($table, $data)) {
                $rs = $this->select($table, $column, $data, 1);

                if (count($rs) > 0) {
                    return $rs[0];
                } else {
                    throw new InsertException(print_r(array($table,$data), true));
                }
            } else {
                throw new InsertException(print_r(array($table,$data), true));
            }
        } else {
            return null;
        }
    }
    final public function autoUpdate($table, $data, $index)
    {
        $UPDATES = 0;

        $ROW = $this->autoTable($table, $index);

        foreach($ROW as $KEY => $VALUE) {
            unset($ROW[$KEY]);
            $ROW[strtolower($KEY)] = $VALUE;
        }

        foreach($data as $KEY => $VALUE) {
            unset($data[$KEY]);
            $data[strtolower($KEY)] = $VALUE;
        }

        foreach($ROW as $KEY => $VALUE) {
            if(array_key_exists($KEY, $data) && $VALUE != $data[$KEY]) {
                $this->update($table, array($KEY => $data[$KEY]), $index, 1);
                $UPDATES++;
            }
        }

        return $UPDATES;
    }
    final public function autoInsert($table, $data)
    {
        $rs = $this->select($table, array(), $data, 1);

        if (count($rs) > 0) {
            return true;
        }

        if ($this->insert($table, $data)) {
            return true;
        }

        return false;
    }

    public function getTablesWithPrefix($prefix)
    {
        $prefixLen = strlen($prefix);

        $_ = array();

        foreach ($this->getTables() as $table) {
            if(substr($table, 0, $prefixLen) == $prefix) {
                $_[] = $table;
            }
        }

        return $_;
    }
}
