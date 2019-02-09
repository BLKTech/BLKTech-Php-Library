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
use BLKTech\DataType\Path;
use \BLKTech\HTTP\Server;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Router extends \BLKTech\DesignPattern\Singleton
{
    private $requestMethod;
    private $requestPathElements;
    
    protected function __construct() 
    {
        parent::__construct();
        
        $request = Server::getRequestFromGlobals();
        $this->requestMethod = $request->getMethod();
        $this->requestPathElements = $request->getURL()->getPath()->getElements();
    }
    
    private function route($method, Path $path, $callback)
    {
        if($method!='ANY' && $this->request->getMethod() != strtoupper($method))
            return;
        
        $lPath = $path->getElements();
        
        if(count($lPath) != count($this->requestPathElements));
            return;
        
            
        $vars = array();
        
        for($i = 0 ; $i < count($lPath) ; $i++)
        {
            $eR = strtolower($this->requestPathElements[$i]);
            $eP = strtolower($lPath[$i]);
            
            if(substr($eP, 0, 1) == '{' && substr($eP, -1, 1) == '}')
                $vars[substr($eP,1,-1)] = $eR;
            elseif($eR == $eP)
                continue;
            else
                return;
        }

        
        $args = array();
        
        foreach((new \ReflectionFunction($callback))->getParameters() as $parameter)
            if(isset($vars[strtolower($parameter)]))
                $args[] = $vars[strtolower($parameter)];
            else
                $args[] = null;
                
        return call_user_func_array($callback, $args);        
    }
    
    public function get(Path $path, $callback)
    {
        return $this->route('GET', $path, $callback);
    }

    public function post(Path $path, $callback)
    {
        return $this->route('POST', $path, $callback);
    }    
    
    public function delete(Path $path, $callback)
    {
        return $this->route('DELETE', $path, $callback);
    }    
    
    public function put(Path $path, $callback)
    {
        return $this->route('PUT', $path, $callback);
    }    
    
    public function head(Path $path, $callback)
    {
        return $this->route('HEAD', $path, $callback);
    }
    
    public function any(Path $path, $callback)
    {
        return $this->route('ANY', $path, $callback);
    }    
}
