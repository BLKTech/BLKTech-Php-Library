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

namespace BLKTech\HTTP;

/**
 *
 * @author TheKito < blankitoracing@gmail.com >
 */
 
abstract class Server 
{
    public static function setup()
    {        
        self::resetBuffer();
    }
    
    public static function resetBuffer()
    {
        // remove all data in output buffer writed by echo, print_r, readfile etc
        while(@ob_end_clean());
        
        // create new empty buffer       
        if (version_compare(PHP_VERSION, '5.4.0', '>='))                 
            ob_start(null, 0, PHP_OUTPUT_HANDLER_STDFLAGS ^ PHP_OUTPUT_HANDLER_REMOVABLE);
        else 
            ob_start(null, 0, false);
    }
    
    public static function getRequestFromGlobals() 
    {
        return new Request(Method::getFromGlobals(), 
                                \BLKTech\DataTypes\URL::getFromGlobals(), 
                                Header::getFromGlobals(),
                                Body::getFromGlobals()
        );
    }   
    
    public static function sendResponse(Response $response)
    { 
        $response->getHeader()->set('Content-Type', $response->getBody()->getContentType());  
        $response->getHeader()->set('Content-Length', $response->getBody()->getContentLength());
        
        self::resetBuffer();        
        http_response_code($response->getCode());
        foreach ($response->getHeader() as $headerName => $headerValue)
            header ($headerName . ': ' . $headerValue, true, $response->getCode());
        
        if(Method::getFromGlobals()!='HEAD')
            $response->getBody()->dump();
        else
            http_response_code(204);
        
        ob_flush();
        exit();
    }    
    
    public static function sendResponseCode($code)
    {
        self::sendResponseCodeMessage($code, Response::getCodeMessage($code));
    }
    
    public static function sendResponseCodeMessage($code, $message)
    {
        self::sendResponse(new Response($code, new Header(), new Body($message)));
    }    


    public function __destruct()
    {
        $request = self::getRequestFromGlobals();
        try 
        {
            $method = $request->getMethod()->__toString();
            if(method_exists($this, $method))
                self::sendResponse($this->$method($request)); 
            else
                self::sendResponseCode(405);
        } 
        catch (\Exception $ex) 
        {            
            self::sendResponseCodeMessage(503, get_class($ex));
        }        
        
    }
}
