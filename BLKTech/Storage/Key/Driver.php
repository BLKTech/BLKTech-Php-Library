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

namespace BLKTech\Storage\Key;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

abstract class Driver implements \BLKTech\Storage\DriverInterface
{
    abstract public function exists($key);
    abstract public function delete($key);
    abstract public function get($key);
    abstract public function set($key, $value);
    abstract public function getKeys();
}
