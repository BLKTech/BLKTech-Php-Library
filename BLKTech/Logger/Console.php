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

namespace BLKTech\Logger;
use \Psr\Log\LoggerInterface;
use \BLKTech\DesignPattern\Singleton;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Console extends Singleton implements LoggerInterface
{        
    
    private $ms=0;
    
    function __construct() 
    {
        parent::__construct();
        $this->debug('Logger Started')    ;
    }

    
    public function alert($message, array $context = array()) {
        $this->log('ALERT', $message, $context);
    }

    public function critical($message, array $context = array()) {
        $this->log('CRITICAL', $message, $context);
    }

    public function debug($message, array $context = array()) {
        $this->log('DEBUG', $message, $context);
    }

    public function emergency($message, array $context = array()) {
        $this->log('EMERGENCY', $message, $context);
    }

    public function error($message, array $context = array()) {
        $this->log('ERROR', $message, $context);
    }

    public function info($message, array $context = array()) {
        $this->log('INFO', $message, $context);
    }

    public function log($level, $message, array $context = array()) {
        error_log("[" . str_pad(round(microtime(true)-$this->ms,8),10,'0',STR_PAD_LEFT) . "]\t" . $level . ": \t" . $message);
        $this->ms = microtime(true);
    }

    public function notice($message, array $context = array()) {
        $this->log('NOTICE', $message, $context);
    }

    public function warning($message, array $context = array()) {
        $this->log('WARNING', $message, $context);
    }

}
