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
use \BLKTech\DataType\Path;
use \BLKTech\HTTP\Server;
use \BLKTech\Logger;

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
        Logger::getInstance()->debug('Request Method: ' . $this->requestMethod);
        Logger::getInstance()->debug('Request Path: ' . implode('/', $this->requestPathElements));
        Logger::getInstance()->debug('Request Length: ' . count($this->requestPathElements));
    }
    
    private function route($method, Path $path, $callback, $strict = true)
    {
        
        Logger::getInstance()->debug('Route Method: ' . $method);

        if($method!='ANY' && $this->requestMethod != strtoupper($method))
            return;

        Logger::getInstance()->debug('Route Method Match');             
        
        $lPath = $path->getElements();
        Logger::getInstance()->debug('Route Path: ' . implode('/', $lPath));   
        Logger::getInstance()->debug('Route Length: ' . count($lPath));

        if($strict)
        {
            Logger::getInstance()->debug('Strict Mode');               
            
            if(count($lPath) != count($this->requestPathElements))
                return;        
        }
        else
        {
            Logger::getInstance()->debug('Non Strict Mode');               
            
            if(count($lPath) > count($this->requestPathElements))
                return;                            
        }
            
        Logger::getInstance()->debug('Path Length Match');   
        
        $vars = array();
        
        for($i = 0 ; $i < count($lPath) ; $i++)
        {
            $eR = strtolower($this->requestPathElements[$i]);
            $eP = strtolower($lPath[$i]);
        
            Logger::getInstance()->debug($eP . '=' . $eR);        
                              
            if(substr($eP, 0, 1) == '{' && substr($eP, -1, 1) == '}')            
                $vars[substr($eP,1,-1)] = $eR;            
            elseif($eR == $eP)
                continue;
            else
                return;
        }

        Logger::getInstance()->debug('Path Match');      
        Logger::getInstance()->debug(json_encode($vars));      
        
        $args = array();
        
        foreach((new \ReflectionFunction($callback))->getParameters() as $parameter)        
            if(isset($vars[strtolower($parameter->name)]))
                $args[] = $vars[strtolower($parameter->name)];
            else
                $args[] = null;
        
        
        Logger::getInstance()->debug(json_encode($args));      
        return call_user_func_array($callback, $args);        
    }
    
    public function get(Path $path, $callback, $strict = true)
    {
        return $this->route('GET', $path, $callback, $strict);
    }

    public function post(Path $path, $callback, $strict = true)
    {
        return $this->route('POST', $path, $callback, $strict);
    }    
    
    public function delete(Path $path, $callback, $strict = true)
    {
        return $this->route('DELETE', $path, $callback, $strict);
    }    
    
    public function put(Path $path, $callback, $strict = true)
    {
        return $this->route('PUT', $path, $callback, $strict);
    }    
    
    public function head(Path $path, $callback, $strict = true)
    {
        return $this->route('HEAD', $path, $callback, $strict);
    }
    
    public function any(Path $path, $callback, $strict = true)
    {
        return $this->route('ANY', $path, $callback, $strict);
    }    
}
