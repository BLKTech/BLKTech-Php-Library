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
    
    private function route($method, Path $path, $callback)
    {
        
        Logger::getInstance()->debug('Route Method: ' . $method);

        if($method!='ANY' && $this->request->getMethod() != strtoupper($method))
            return;

        Logger::getInstance()->debug('Route Method Match');             
        
        $lPath = $path->getElements();
        Logger::getInstance()->debug('Route Path: ' . implode('/', $lPath));   
        Logger::getInstance()->debug('Route Length: ' . count($lPath));

        if(count($lPath) != count($this->requestPathElements))
            return;        
        
        Logger::getInstance()->debug('Path Length Match');             
            
        $vars = array();
        
        for($i = 0 ; $i < count($lPath) ; $i++)
        {
            $eR = strtolower($this->requestPathElements[$i]);
            $eP = strtolower($lPath[$i]);
        
            Logger::getInstance()->debug($eP . '=' . $eR);        
            
            Logger::getInstance()->debug(substr($eP, 0, 1));        
            Logger::getInstance()->debug(substr($eP, -1, 1));        
            
            if(substr($eP, 0, 1) == '{' && substr($eP, -1, 1) == '}')
            {
                $vars[substr($eP,1,-1)] = $eR;
                Logger::getInstance()->debug(substr($eP,1,-1) . '=' . $eR);        
            }
            elseif($eR == $eP)
                continue;
            else
                return;
        }

        Logger::getInstance()->debug('Path Match');      
        
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
