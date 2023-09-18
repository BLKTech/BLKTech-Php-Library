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

namespace BLKTech\XML\Document;

use BLKTech\XML\Document;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */

class HTML extends Document
{
    public function __construct()
    {
        parent::__construct();
        parent::setDeclaration('!DOCTYPE html');
        parent::addElement(new \BLKTech\XML\Element\Tag\HTML());
    }




}
