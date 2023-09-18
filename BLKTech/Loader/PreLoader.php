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

namespace BLKTech\Loader;

Preloader::preLoad();

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Preloader
{
    private static $clasess = array(
         'BLKTech/DesignPattern/Singleton',
         'BLKTech/DataType/Path',
         'BLKTech/DataType/HashTable',
         'BLKTech/DataType/Query',
         'BLKTech/DataType/Service',
         'BLKTech/DataType/URL',
         'BLKTech/FileSystem/FileSystem',
         'BLKTech/FileSystem/Directory',
         'BLKTech/FileSystem/File',
         'BLKTech/Loader/Library',
         'BLKTech/Loader/Loader',
    );

    public static function preLoad()
    {
        foreach (self::$clasess as $class) {
            require_once __DIR__ . '/../../' . $class . '.php';
        }

        Loader::getInstance();
    }

}
