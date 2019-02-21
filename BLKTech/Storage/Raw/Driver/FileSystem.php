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

namespace BLKTech\Storage\Raw\Driver;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
class FileSystem extends \BLKTech\Storage\Driver
{
    private $rootDirectory;
    function __construct(\BLKTech\FileSystem\Directory $rootDirectory) 
    {
        $this->rootDirectory = $rootDirectory;
        \Logger::getInstance()->debug("FileSystemDriver UID:".$this->getUID());
    }

    private function getFileById($id)
    {
        $id = strtoupper($id);
        
        $newPath = $this->rootDirectory;
        
        $pathElements = array();
        
        foreach(array_merge(range('A', 'Z'), range(0, 9)) as $char)
            if(strpos($id, $char)!==FALSE) 
                    $newPath = $newPath->getChild ($char);                    
            
        $newPath = $newPath->getChild ($id);
        return new \BLKTech\FileSystem\File($newPath);
    }
    
    public function exists($id) 
    {        
        return self::getFileById($id)->exists();
    }
    
    public function spaceAvailable() 
    {
        return $this->rootDirectory->getFreeSpace();
    }

    public function delete($id) 
    {
        return self::getFileById($id)->delete();
    }

    public function get($id) 
    {   
        return self::getFileById($id)->getContent();
    }

    public function set($id, $data) 
    {
        $file = self::getFileById($id);                
        $file->getParent()->create();
        $file->setContent($data);    
    }

    public function getUID() 
    {
        return $this->rootDirectory->getUID();
    }

}
