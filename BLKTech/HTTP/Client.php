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
 
class Client 
{

    
    public static function call(Request $request, $deep = 10)
    {
        $curl = curl_init();       
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);        
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request->getMethod()->__toString());
        curl_setopt($curl, CURLOPT_URL, $request->getURL()->__toString());
        curl_setopt($curl, CURLOPT_HTTPHEADER, $request->getHeader()->getList()); 
        $body = $request->getBody()->__toString();
        curl_setopt($curl, CURLOPT_POST, $body!==null);        
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);        
        
        $cr = curl_exec($curl);
        $hs = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = Header::getFromString(substr($cr, 0, $hs));        
        $body = Body::fromString(substr($cr, $hs));
        unset($hs);        
        unset($cr);
        
        if($header->get('location')!==null && $deep>0)        
            return self::call (new Request(
                    Method::GET(), 
                    $request->getURL()->combineURL(\BLKTech\DataTypes\URL::getFromString($headers->get('location'))), 
                    new Header(array('Referer'=>$request->getURL()->__toString())), 
                    null
                ), $deep-1);
        
        
        return new Response(curl_getinfo($curl, CURLINFO_HTTP_CODE), $header, $body);        
    }
}
