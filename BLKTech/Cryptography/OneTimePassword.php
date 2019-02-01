<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\Cryptography;

/**
 * Description of OneTimePassword
 *
 * @author instalacion
 */
class OneTimePassword {
    private $hashAlgorithm;
    private $passwordHash;
    private $passwordCurrent;
    
    private $timeDivider;
    private $timeOffset;
    private $timeCurrent;            
    
    public function __construct(Hash $hashAlgorithm, $password, int $timeDivider = 60, int $timeOffset = 0) 
    {
        $this->hashAlgorithm = $hashAlgorithm;
        $this->passwordHash = $hashAlgorithm->calc($password);
        $this->timeDivider = $timeDivider;
        $this->timeOffset = $timeOffset;
    }

    public function getTimeOffset() 
    {
        return $this->timeOffset;
    }
    public function setTimeOffset($timeOffset) 
    {
        if($this->timeOffset != $timeOffset)
        {
            $this->timeOffset = $timeOffset;
            $this->passwordCurrent = null;
        }
    }    
    private function getTime()
    {
        return time() + $this->timeOffset;
    }
    
    
    public function getTimeDivider() 
    {
        return $this->timeDivider;
    }
    function setTimeDivider($timeDivider) 
    {
        if($this->timeDivider != $timeDivider)
        {        
            $this->timeDivider = $timeDivider;
            $this->passwordCurrent = null;
        }
    }
    private function getSubTime()
    {
        return $this->getTime() & $this->timeDivider;
    }
  
    public function getOneTimePassword(int $timeOffset = null)
    {
        if($timeOffset !== null)
            $this->setTimeOffset ($timeOffset);
        
        $timeCurrent = $this->getSubTime();
        
        if($this->passwordCurrent === null || $this->timeCurrent != $timeCurrent)
        {
            $this->timeCurrent = $timeCurrent;
            
            //
        }
        
        
        return $this->passwordCurrent;
    }


}
