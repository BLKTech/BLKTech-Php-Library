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
namespace BLKTech\HTTP\Server;
use BLKTech\HTTP\Request;
use BLKTech\DataType\Path;
/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Router extends \BLKTech\DesignPattern\Singleton
{
    private $request;
    protected function __construct() 
    {
        parent::__construct();
        
        $this->request = \BLKTech\HTTP\Server::getRequestFromGlobals();
    }
    
    public function route($method, Path $path, $function)
    {
        if($this->request->getMethod() != strtoupper($method))
            return;
        
        if($path->getDeep() != $this->request->getURL()->getPath()->getDeep());
            return;
        
        
    }
    
    public function get(Path $path, $function)
    {
        return $this->route('GET', $path, $function);
    }

    public function post(Path $path, $function)
    {
        return $this->route('POST', $path, $function);
    }    
    
    public function delete(Path $path, $function)
    {
        return $this->route('DELETE', $path, $function);
    }    
    
    public function put(Path $path, $function)
    {
        return $this->route('PUT', $path, $function);
    }    
    
    public function HEAD(Path $path, $function)
    {
        return $this->route('HEAD', $path, $function);
    }
}
