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

namespace BLKTech\FileSystem\File;

use BLKTech\FileSystem\Exception\IOException;
use BLKTech\DataType\Path;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Reader extends \BLKTech\FileSystem\File
{
    private $handle = false;

    public function __construct(Path $path)
    {
        parent::__construct($path);

        parent::validateExistence();
        parent::validateReadable();

        $this->handle = fopen($this->__toString(), 'r');

        if($this->handle === false) {
            throw new IOException($this->__toString());
        }
    }

    public function readLine($maxLength = null)
    {
        if($this->eof()) {
            return null;
        }

        if ($maxLength === null) {
            $maxLength = 1024;
        }

        $line = trim(str_replace("\n", '', str_replace("\r", '', fgets($this->handle, $maxLength))));

        if($line === false) {
            throw new IOException($this->__toString());
        }

        return $line;
    }

    public function read($length)
    {
        if($this->eof()) {
            return null;
        }

        $line = fread($this->handle, $length);

        if($line === false) {
            throw new IOException($this->__toString());
        }

        return $line;
    }

    public function eof()
    {
        return feof($this->handle);
    }

    public function __destruct()
    {
        if($this->handle !== false) {
            if(!fclose($this->handle)) {
                throw new IOException($this->__toString());
            }
        }
    }
}
