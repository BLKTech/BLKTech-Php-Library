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

namespace BLKTech\Loader;
use \BLKTech\DesignPattern\Singleton;

/**
 * Description of Loader
 *
 * @author TheKito < blankitoracing@gmail.com >
 * ref https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
 */

class Loader extends Singleton
{        
    /**
     * Register loader with SPL autoloader stack.
     *
     * @return void
     */    
    public function register()
    {
        static $registered = FALSE;
        
        if($registered)
            return;
        
        $registered = spl_autoload_register(array($this, 'loadClass'));
    }
    
    
}
