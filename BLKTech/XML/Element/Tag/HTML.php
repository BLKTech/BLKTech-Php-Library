<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BLKTech\XML\Element\Tag;

use BLKTech\XML\Element\Tag;

/**
 * Description of HTML
 *
 * @author instalacion
 */
class HTML extends Tag
{
    private $head;
    private $body;

    public function __construct()
    {
        parent::__construct();
        $this->head = new HTML\Head();
        $this->body = new HTML\Body();
        parent::addElement($this->head);
        parent::addElement($this->body);
    }

    public function getHead()
    {
        return $this->head;
    }

    public function getBody()
    {
        return $this->body;
    }


}
