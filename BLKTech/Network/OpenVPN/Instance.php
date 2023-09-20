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
use BLKTech\FileSystem\Directory;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Instance
{
    public function getInstances(Directory $configDirectory = null)
    {
        if($configDirectory === null) {
            $configDirectory = Directory::getFromStringPath('/etc/openvpn');
        }

        $_ = array();

        foreach($configDirectory->getChildren() as $fso) {
            if($fso instanceof File && strtolower($fso->getExtension()) == 'conf') {
                $_[] = new self($fso);
            }
        }

        return $_;
    }

    private $configFile;
    private $lastRead = 0;
    private $keys = array();

    public function __construct(File $configFile)
    {
        $this->configFile = $configFile;
    }

    public function getStatus()
    {
        $this->parseFile();

        if(!isset($this->keys['status'])) {
            return null;
        }

        return new Status(File::getFromStringPath($this->keys['status']));
    }


    private function parseFile()
    {
        if($this->configFile->getModificationTime() <= $this->lastRead) {
            return;
        }

        $this->lastRead = time();

        $reader = $this->configFile->getReader();

        $this->keys = array();

        while(!$reader->eof()) {
            $line = trim(explode('#', $reader->readLine(), 2)[0]);

            if($line == '') {
                continue;
            }

            $line = explode(' ', $line);

            foreach($line as $index => $value) {
                $value = trim($value);

                if($value == '') {
                    unset($line[$index]);
                } else {
                    $line[$index] = $value;
                }
            }

            if(count($line) > 0) {
                $key = strtolower(array_shift($line));

                if(!isset($this->keys[$key])) {
                    $this->keys[$key] = array();
                }

                $list = $this->keys[$key];

                $list[] = implode(' ', $line);

                $this->keys[$key] = $list;
            }
        }

        foreach($this->keys as $index => $value) {
            if(count($value) == 1) {
                $this->keys[$index] = array_shift($value);
            }
        }
    }
}
