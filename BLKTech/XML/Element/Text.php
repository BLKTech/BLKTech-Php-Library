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

use BLKTech\XML\Element;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Text extends Element
{
    private $text;

    public function __construct($text)
    {
        $this->text = utf8_encode($text);
    }

    public function dump($level)
    {
        echo $this->toString($level);
    }

    public function toString($level)
    {
        return parent::getTabs($level). '<![CDATA[ ' . PHP_EOL  .$this->text . PHP_EOL . parent::getTabs($level) .' ]]>';
    }

}
