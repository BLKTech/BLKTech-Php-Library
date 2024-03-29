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

namespace BLKTech;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Exception extends \Exception
{
    public static function throwException(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        throw new static($message, $code, $previous);
    }

    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $classFullName = get_class($this);

        if($code === 0 || $code === null) {
            $code = crc32($classFullName);
        }

        parent::__construct($classFullName . ': ' . $message, $code, $previous);
    }

}
