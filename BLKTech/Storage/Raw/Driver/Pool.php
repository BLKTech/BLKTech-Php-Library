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

namespace BLKTech\Storage\Raw\Driver;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Pool extends Driver
{
    private $nodes;
    private $replicas;
    public function __construct($replicas = 1)
    {
        $this->nodes = array();
        $this->replicas = $replicas;
    }
    public function addNode(Driver $node)
    {
        $this->nodes[$node->getUID()] = $node;

        shuffle($this->nodes);

        $_ = array();
        foreach ($this->nodes as $node) {
            $_[$node->getUID()] = $node;
        }

        $this->nodes = $_;
    }

    public function delete($id)
    {
        foreach ($this->nodes as $node) {
            $node->delete($id);
        }
    }

    public function exists($id)
    {
        foreach ($this->nodes as $node) {
            if($node->exists($id)) {
                return true;
            }
        }

        return false;
    }

    public function get($id)
    {
        foreach ($this->nodes as $node) {
            if($node->exists($id)) {
                return $node->get($id);
            }
        }

        throw new IDNotFoundException($id);
    }

    public function set($id, $data)
    {
        $_ = array();
        foreach ($this->nodes as $node) {
            $_[$node->getUID()] = $node->spaceAvailable();
        }

        asort($_, SORT_NUMERIC);
        $_ = array_slice(array_reverse(array_keys($_)), 0, $this->replicas);

        $this->delete($id);

        foreach ($_ as $uid) {
            $this->nodes[$uid]->set($id, $data);
        }
    }

    public function spaceAvailable()
    {
        $total = 0;
        foreach ($this->nodes as $node) {
            $total = $total + $node->spaceAvailable();
        }
        return $total / $this->replicas;
    }

    public function getUID()
    {
        return implode("#", array_keys($this->nodes));
    }

}
