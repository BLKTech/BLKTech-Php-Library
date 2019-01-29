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
use \BLKTech\DataType\URL;
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
    
    protected function __construct() 
    {
        parent::__construct();
        spl_autoload_register(array($this, 'loadClass'));
        $this->addLibrary(new Library(
                    Path::getPathFromString('/BLKTech'), 
                    Path::getPathFromString(__DIR__ . '/../'), 
                    URL::getFromString('https://psr0.blktech.org/BLKTech')
                ));
        $this->addLibrary(new Library(
                    Path::getPathFromString('/Psr'), 
                    Path::getPathFromString(__DIR__ . '/../../Psr'), 
                    URL::getFromString('https://psr0.blktech.org/Psr')
                ));        
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
     * @param string $classNameSpace The fully-qualified class name.
     * @return mixed The mapped file name on success, or boolean false on
     * failure.
     */
    public function loadClass($classNameSpace)
    {
        self::log('SPL Loading ' . $classNameSpace);
        
        $classPath = Path::getPathFromString($classNameSpace,"\\");
        
        $nameSpacePath = $classPath->getParent();
        $middle = array();
        while(!$nameSpacePath->isRoot())
        {
            if(isset($this->libraries[$nameSpacePath->__toString()]))
            {
                self::log('Library match ' . $nameSpacePath->__toString());
                if(self::tryFind(
                        $this->libraries[$nameSpacePath->__toString()],
                        $middle,
                        $classPath->getName() . '.php'                        
                )){break;}
            }
            
            $middle[] = $nameSpacePath->getName();
            $nameSpacePath = $nameSpacePath->getParent();
        }
    }

    private static function getFilePath(Library $library,$middle,$className)
    {
        $basePath = $library->getPath();        
        $middlePath = Path::getPathFromString(implode(DIRECTORY_SEPARATOR, $middle));
        $classNamePath = Path::getPathFromString($className);       
        return $basePath->combinePath($middlePath)->combinePath($classNamePath);        
    }
    
    private static function getFileURL(Library $library,$middle,$className)
    {
        $baseURL = $library->getUrl();
        $middleURL = URL::getFromString(implode('/', $middle));
        $classNameURL = URL::getFromString($className);        
        return $baseURL->combineURL($middleURL)->combineURL($classNameURL);        
    }
    
    private static function tryLoad(Path $filePath)
    {        
        self::log('Trying Load Path ' . $filePath->__toString());

        if(file_exists($filePath->__toString()))
            require_once $filePath->__toString();        
    }
    
    private static function writeClass(Path $filePath,$data)
    {
        $dirPath = $filePath->getParent()->__toString();                
        if(is_dir ($dirPath) || mkdir($dirPath, 0777, true))
            return file_put_contents($filePath->__toString(), $data)!==FALSE;                
                
        return false;
    }
    
    private static function tryFind($library,$middle,$className)
    {
        $filePath = self::getFilePath($library, $middle, $className);

        if(file_exists($filePath->__toString()))
        {
            return self::tryLoad($filePath);            
        }      
        elseif($library->getUrl()!==NULL)
        {
            $fileURL = self::getFileURL($library, $middle, $className);
            $url = $fileURL->__toString();
            self::log('File Not Found, Trying Download: '.$url);            
            $data = @file_get_contents($url);
            
            if($data!==FALSE && self::writeClass($filePath, $data))
            {   
                return self::tryLoad($filePath);;
            }
        }
        
        return false;
    }
    
    private static function log($message)
    {
        if(class_exists('Logger',false))
            Logger::getInstance()->debug($message);
        else
            error_log ($message);
    }
    
}
