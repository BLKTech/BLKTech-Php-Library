<?php
    defined('__DIR__') || define('__DIR__', dirname(__FILE__));
    ini_set("display_errors", 0);
    error_reporting(E_ALL);

    
    set_error_handler (
        function($errno, $errstr, $errfile, $errline) 
        {
            if(class_exists('Logger',false))
            {
                $message = $errfile.':'.$errline.'    '.$errstr.':'.$errno;
                switch ($errno) 
                {
                    case E_ERROR:
                    case E_USER_ERROR:
                    case E_CORE_ERROR:
                    case E_COMPILE_ERROR:
                    case E_RECOVERABLE_ERROR:
                        Logger::getInstance()->error($message);
						throw new ErrorException($errstr, $errno, 0, $errfile, $errline);     
                    case E_WARNING:
                    case E_USER_WARNING:
                    case E_CORE_WARNING:
                    case E_COMPILE_WARNING:
                        Logger::getInstance()->warning($message);   
                    case E_DEPRECATED:      
                    case E_USER_DEPRECATED:      
                        Logger::getInstance()->info($message);                                                                                                
                    case E_NOTICE:
                    case E_USER_NOTICE:
                        Logger::getInstance()->notice($message);                                                
                    case E_ALL:
                    case E_PARSE:
                    case E_STRICT:
                        Logger::getInstance()->debug($message);                                                
                }

            }            
                
        }
    );

    register_shutdown_function(
        function ()
        {
            $last_error = error_get_last();            
            if ($last_error['type'] === E_ERROR)
                throw new ErrorException($last_error['message'], E_ERROR, 0, $last_error['file'], $last_error['line']);     
        }            
    );

    spl_autoload_register(
        function ($classNameSpace) 
        {         
            
            class_exists('Logger',false) && Logger::getInstance()->debug('SPL Loading ' . $classNameSpace);
            
            $classNameSpace = explode(DIRECTORY_SEPARATOR, str_replace('/', DIRECTORY_SEPARATOR, str_replace("\\", DIRECTORY_SEPARATOR, $classNameSpace)));

            foreach ($classNameSpace as $key => $value)
                if(empty($value) || $value=='.' || $value=='..')
                    unset ($classNameSpace[$key]);

            $classPath = __DIR__ . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $classNameSpace) . '.php';

            if(!file_exists($classPath))        
            {
                class_exists('Logger',false) && Logger::getInstance()->debug('Class not found trying to download');

                try
                {
                    $data = @file_get_contents('https://psr0.blktech.org/'.implode('/',$classNameSpace).'.php');
                    if($data!==FALSE)
                    {
                        class_exists('Logger',false) && Logger::getInstance()->debug('Class downloaded');
                        
                        $_ = $classNameSpace;
                        $className = array_pop($_);

                        is_dir(__DIR__ . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $_)) || mkdir(__DIR__ . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $_), 0777, true);
                        file_put_contents($classPath, $data);
                    }
                    else
                        class_exists('Logger',false) && Logger::getInstance()->debug('Class not found on server');
                }
                catch (\Throwable $t)
                {
                    class_exists('Logger',false) && Logger::getInstance()->warning($t->getMessage());
                }   
            }

            if(file_exists($classPath))        
                require_once $classPath;

            else if(substr (end($classNameSpace), -9) == 'Exception')  
            {             
                class_exists('Logger',false) && Logger::getInstance()->debug('Class it is a Exception creating...');                
                
                $_ = $classNameSpace;
                $className = array_pop($_);
                $extends = "\\" . implode("\\", $_) . 'Exception';

                if(count($_)>0)
                    eval('namespace ' .  implode("\\", $_) . '{ class ' . $className . ' extends '.$extends.' {} }');
                else
                    eval('class ' . $className . ' extends '.$extends.' {}');                
            }
            
            if(!class_exists(implode("\\",$classNameSpace), false) && !interface_exists (implode("\\",$classNameSpace), false) &&! trait_exists(implode("\\",$classNameSpace), false) )
            {
                class_exists('Logger',false) && Logger::getInstance()->emergency('Class not found');
                throw new BLKTech\Loader\ClassNotFoundException(implode("\\",$classNameSpace));
            }
        }
    );
   
    
    
    try 
    {
        class_exists('Logger');
        
        if(!method_exists('\Application','Main'))         
            throw new BLKTech\Loader\StaticMethodNotFoundException('\Application::Main()');
        
        \Application::Main();
    } 
    catch (\Throwable $t)
    {
        $data = print_r(array($t, get_defined_vars()),true);
        error_log($data);
        @mail('debug@blktech.org', 'Loader', $data);
        die($t->getMessage());
    }