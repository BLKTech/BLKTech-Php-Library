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
 
class Request extends Message
{    
    private $method;
    private $url;
    
    public function __construct(Method $method, \BLKTech\DataTypes\URL $url,Header $header, $payload) 
    {
        parent::__construct($header, $payload);       
        $this->method = $method;
        $this->url = $url;
    }
    
    public function getMethod() {return $this->method;}
    public function getURL() {return $this->url;}       
}
 