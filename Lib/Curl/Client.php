<?php

namespace Lib\Curl;

/**
 * @brief   Curl client that make http requests
 */
class Client
{
    /**
     * @brief   Execute http request
     * 
     * @param   string $url
     * @param   array $params
     * @param   string $method
     * 
     * @return  string
     */
    public function execute( $url, array $params = array(), $method = 'GET' )
    {
        $ch     = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        
        if($method === 'POST')
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($params));
        }
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($ch);
        
        return $result;
    }
}