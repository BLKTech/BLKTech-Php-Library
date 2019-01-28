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

namespace BLKTech\Loader;
use BLKTech\Loader\Library;
use \BLKTech\DataType\Path;
use \BLKTech\DesignPattern\Singleton;


/**
 * Description of Loader
 *
 * @author TheKito < blankitoracing@gmail.com >
 * ref https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
 */

class Loader extends Singleton
{        
    /**
     * An associative array where the key is a namespace prefix and the value
     * is an instance of Library class.
     *
     * @var array
     */
    protected $libraries = array();    
    
    /**
     * Register loader with SPL autoloader stack.
     *
     * @return void
     */    
    public function register()
    {
        static $registered = FALSE;
        
        if($registered)
            return;
        
        $registered = spl_autoload_register(array($this, 'loadClass'));
    }
    
    /**
     * Adds a Library
     *
     * @param Library $library
     * @return void
     */
    public function addLibrary(Library $library)
    {
        $this->libraries[$library->getNamespace()->__toString()] = $library;
    }    
    
    /**
     * Loads the class file for a given class name.
     *
     * @param string $class The fully-qualified class name.
     * @return mixed The mapped file name on success, or boolean false on
     * failure.
     */
    public function loadClass($class)
    {
        $classPath = Path::getPathFromString($class);
        
        $nameSpacePath = $classPath->getParent();
        $middle = array();
        while(!$nameSpacePath->isRoot())
        {
            if(isset($this->libraries[$nameSpacePath->__toString()]))
            {
                $library = $this->libraries[$nameSpacePath->__toString()];
                
                $basePath = $library->getPath();
                error_log($basePath->__toString());
                
                $middlePath = Path::getPathFromString(implode(DIRECTORY_SEPARATOR, $middle));
                error_log($middlePath->__toString());
                
                $className = $classPath->getName();
                error_log($className->__toString());

                
                $filePath = $basePath->combinePath($middlePath)->combinePath($className);
                error_log($filePath->__toString());
                
                
                var_dump("BASE:" . $nameSpacePath->__toString());
                print_r($middle);                
                var_dump("CLASE:" . $classPath->getName());
                
                
                
                
                
                break;
            }            
            
            $middle[] = $nameSpacePath->getName();
            $nameSpacePath = $nameSpacePath->getParent();
        }
    }

}
