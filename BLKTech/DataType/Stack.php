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

namespace BLKTech\DataType;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
abstract class Stack 
{
   public abstract function push($e);
   public abstract function pop();
   public abstract function peek();
   
   public abstract function clear();
   public abstract function isEmpty();
}
