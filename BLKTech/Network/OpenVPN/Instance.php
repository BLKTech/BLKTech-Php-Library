<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\Network\OpenVPN;
use BLKTech\FileSystem\File;
/**
 * Description of Instance
 *
 * @author instalacion
 */
class Instance {
    
    private $configFile;
    private $lastRead = 0;
    
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
        
        
    }
}
