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
    private $schemeSeparator;


    public function __construct($host, $port = null, $scheme = null, $user = null, $passowrd = null, $schemeSeparator = '://')
    {
        $this->host = $host;
        $this->port = $port;
        $this->scheme = $scheme;
        $this->user = $user;
        $this->passowrd = $passowrd;
        $this->schemeSeparator = $schemeSeparator;
    }



    public function getUser()
    {
        return $this->user;
    }

    public function getPassowrd()
    {
        return $this->passowrd;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function setPassowrd($passowrd)
    {
        $this->passowrd = $passowrd;
        return $this;
    }

    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }



    public function __toString()
    {
        $_ = '';

        if($this->scheme!==null) {
            $_.= $this->scheme . $this->schemeSeparator;
        }

        if($this->user!==null) {
            $_.= $this->user;

            if($this->passowrd!==null) {
                $_.= ':' . $this->passowrd;
            }

            $_.= '@';
        }

        if($this->host!==null) {
            $_.= $this->host;
        }

        if($this->port!==null) {
            $_.= ':' . $this->port;
        }

        return $_;
    }

}
