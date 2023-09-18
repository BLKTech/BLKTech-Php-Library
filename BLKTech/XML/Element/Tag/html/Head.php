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

namespace BLKTech\XML\Element\Tag\HTML;

use BLKTech\XML\Element\Tag;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class Head extends Tag
{
    private $title;

    public function __construct()
    {
        parent::__construct();
        $this->title = new head\Title();
        parent::addElement($this->title);
    }


}
