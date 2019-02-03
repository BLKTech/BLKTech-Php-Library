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

namespace BLKTech\Network\OpenVPN;
use BLKTech\FileSystem\File;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Instance {
    
    private $configFile;
    private $lastRead = 0;
    private $keys = array();
    
    public function __construct(File $configFile) 
    {
        $this->configFile = $configFile;
    }

    private function parseFile()
    {
        if($this->configFile->getModificationTime() <= $this->lastRead)
            return;
        
        $this->lastRead = time();
        
        $reader = $this->configFile->getReader();
        
        $this->keys = array();
        
        while(!$reader->eof())
        {            
            $line = trim(explode('#', $reader->readLine(),2)[0]);
            
            if($line=='')
                continue;
            
            $line = explode(' ', $line);
            
            foreach($line as $index => $value)
            {
                $value = trim($value);
                
                if($value=='')
                    unset($line[$index]);
                else
                    $line[$index] = $value;
            }
            
            if(count($line)>0)
            {
                $key = array_shift($line);

                if(!isset($this->keys[$key]))
                    $this->keys[$key] = array();

                $list = $this->keys[$key];

                $list[] = implode(' ', $line);

                $this->keys[$key] = $list;
            }
        }
        
    }
}
