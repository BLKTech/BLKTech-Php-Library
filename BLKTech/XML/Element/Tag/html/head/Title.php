<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\XML\Element\Tag\HTML\head;

use BLKTech\XML\Element\Tag;

/**
 * Description of Title
 *
 * @author instalacion
 */
class Title extends Tag
{
    public function __construct($title)
    {
        parent::__construct();
        parent::addElement(new \BLKTech\XML\Element\Text($title));
    }

}
