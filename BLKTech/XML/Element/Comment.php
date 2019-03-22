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

namespace BLKTech\XML\Element;
use \BLKTech\XML\Element;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
class Comment extends Element
{
    private $comment;
    
    public function __construct($comment) 
    {
        $this->comment = utf8_encode($comment);
    }

    public function dump($level) 
    {
        echo $this->toString($level);
    }

    public function toString($level) 
    {
        return parent::getTabs($level). '<!-- ' . PHP_EOL  .$this->text . PHP_EOL . parent::getTabs($level) .' -->';
    }
}
