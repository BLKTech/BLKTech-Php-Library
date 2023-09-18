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

namespace BLKTech\HTTP;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Method
{
    public static function getFromGlobals()
    {
        switch (strtoupper(trim(filter_input(INPUT_SERVER, 'REQUEST_METHOD')))) {
            case 'CONNECT':
                return self::CONNECT();
            case 'DELETE':
                return self::DELETE();
            case 'GET':
                return self::GET();
            case 'HEAD':
                return self::HEAD();
            case 'OPTIONS':
                return self::OPTIONS();
            case 'PATCH':
                return self::PATCH();
            case 'POST':
                return self::POST();
            case 'PUT':
                return self::PUT();
            case 'TRACE':
                return self::TRACE();
        }

        Exception::throwByHTTPCode(420);
    }


    public static function POST()
    {
        return new Method('POST');
    }
    public static function GET()
    {
        return new Method('GET');
    }
    public static function PUT()
    {
        return new Method('PUT');
    }
    public static function DELETE()
    {
        return new Method('DELETE');
    }
    public static function HEAD()
    {
        return new Method('HEAD');
    }
    public static function CONNECT()
    {
        return new Method('CONNECT');
    }
    public static function OPTIONS()
    {
        return new Method('OPTIONS');
    }
    public static function TRACE()
    {
        return new Method('TRACE');
    }
    public static function PATCH()
    {
        return new Method('PATCH');
    }

    private $method;
    private function __construct($method)
    {
        $this->method = $method;
    }
    public function __toString()
    {
        return $this->method;
    }
}
