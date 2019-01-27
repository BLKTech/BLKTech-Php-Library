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

namespace BLKTech\DataType;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
class Service 
{

    private $host;
    private $port;
    private $scheme;
    private $user;
    private $passowrd;


    
    function __construct($host, $port, $scheme = null, $user = null, $passowrd = null, $schemeSeparator = '://') {
        $this->host = $host;
        $this->port = $port;
        $this->scheme = $scheme;
        $this->user = $user;
        $this->passowrd = $passowrd;                
    }

    

    function getUser() 
    {
        return $this->user;
    }

    function getPassowrd() 
    {
        return $this->passowrd;
    }

    function getHost() 
    {
        return $this->host;
    }

    function getPort() 
    {
        return $this->port;    
    }

    function setUser($user) 
    {
        $this->user = $user;
        return $this;
    }

    function setPassowrd($passowrd) 
    {
        $this->passowrd = $passowrd;
        return $this;
    }

    function setHost($host) 
    {
        $this->host = $host;
        return $this;
    }

    function setPort($port) 
    {
        $this->port = $port;
        return $this;
    }



    
}
