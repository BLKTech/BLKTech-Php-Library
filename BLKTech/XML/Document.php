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

namespace BLKTech\XML;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Document
{
    private $declaration = '?xml version="1.0" encoding="UTF-8"?';
    private $elements = array();

    public function __construct($declaration = '?xml version="1.0" encoding="UTF-8"?')
    {
        $this->declaration = $declaration;
    }

    public function getDeclaration()
    {
        return $this->declaration;
    }

    protected function setDeclaration($declaration)
    {
        $this->declaration = $declaration;
    }

    public function addElement(Element $element)
    {
        $this->elements[] = $element;
    }

    public function __toString()
    {
        return $this->toString(0);
    }

    public function toString($level)
    {
        $_ = '<'.$this->declaration.'>'.PHP_EOL;

        foreach ($this->elements as $element) {
            $_ .= $element->toString($level+1);
        }

        return $_;
    }

    public function dump($level)
    {
        echo  '<'.$this->declaration.'>'.PHP_EOL;
        foreach ($this->elements as $element) {
            $element->dump($level);
        }
    }
}
