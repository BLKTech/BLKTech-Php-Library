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

class URL
{    
    public static function parseURL($stringURL)
    {
//        $enc_url = preg_replace_callback(
//            '%[^:/@?&=#]+%usD',
//            function ($matches)
//            {
//                return urlencode($matches[0]);
//            },
//            $stringURL
//        );
                
        return parse_url($stringURL);        
    }
    
    public static function getFromString($stringURL)
    {
        return new URL(self::parseURL($stringURL));
    }
    public static function getFromGlobals()
    {
        $ssl      = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';
        $protocol = (empty($_SERVER['SERVER_PROTOCOL'])?'http':substr($_SERVER['SERVER_PROTOCOL'], 0, strpos($_SERVER['SERVER_PROTOCOL'], '/'))) . ($ssl?'s':'');
        $port     = empty($_SERVER['SERVER_PORT'])?($ssl?443:80):$_SERVER['SERVER_PORT'];
        $host     = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:$_SERVER['SERVER_NAME'];  
        return self::getFromString($protocol . ':// ' . $host . ':' . $port . $_SERVER['REQUEST_URI']);        
    }
            
    protected $urlElements;
 
    protected $path;
    protected $query;
    protected function __construct($urlElements = array())
    {        
        $this->urlElements = $urlElements;
        
        if(isset($urlElements['path']))
            $this->path = Path::getPathFromString($urlElements['path'], '/');
        else
            $this->path = Path::getRoot('/');
        
        if(isset($urlElements['query']))        
            $this->query = Query::getFromString ($urlElements['query']);
        else
            $this->query = Query::getFromString ('');
    }    
    
    private function getElement($element,$default=null,$prefix='',$suffix='') 
    {
        if(!isset($this->urlElements[$element]))
            return $default;
        
        return $prefix.$this->urlElements[$element].$suffix;
    }
    
    public function getScheme()     {return $this->getElement('scheme');}
    public function getHost()       {return $this->getElement('host');}
    public function getPort()       {return $this->getElement('port');}
    public function getUser()       {return $this->getElement('user');}
    public function getPassword()   {return $this->getElement('password');}
    public function getPath()       {return $this->path;}
    public function getQuery()      {return $this->query;}
    public function getFragment()   {return $this->getElement('fragment');}
   
    public function __toString() 
    { 
        $scheme = $this->getElement('scheme','//','','://');  
        
        $pass   = $this->getElement('password',':','@');                
        if($pass==null)
            $user   = $this->getElement('user','','','@');        
        else
            $user   = $this->getElement('user','','',$pass);        
        
        $host     = $this->getElement('host','');
        $port     =  $this->getElement('port','',':');

        $path     = $this->path->__toString(); 

        $query    = $this->query->__toString();
        if(!empty($query))
            $query = '?' . $query;
        
        $fragment = $this->getElement('fragment','','#');

        return "$scheme$user$host$port$path$query$fragment"; 
    } 
    
    public function combineURL(URL $otherURL)
    {             
        if($otherURL->getElement('host')!==null)
            return $otherURL;
                       
        $elements = $this->urlElements;
        $elements['path'] = $this->getPath()->combinePath($otherURL->getPath())->__toString();
        return new URL($elements);
    }
}
