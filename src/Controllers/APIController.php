<?php

namespace StackbotNotifier\Controllers;

class APIController{
    private const API_DOMAIN = 'https://api.stackexchange.com/2.3/';
    private const API_ENDPOINTS = [
        'REPUTATION.CHANGE' => 'users/4964822/reputation',
        'INBOX.UNREAD' => 'inbox/unread'
    ];

    public static function makeAPICall($endPointURI, $params = [], $method = 'GET'){        
        try{
            $method = strtoupper($method);
            $ch = curl_init();
            $absoluteEndpoint = self::API_DOMAIN . self::API_ENDPOINTS[ $endPointURI];

            if($method == 'GET'){
                $absoluteEndpoint .= '?' . http_build_query($params);
            }

            curl_setopt($ch, CURLOPT_URL, $absoluteEndpoint);
            
            if($method == 'POST'){
                curl_setopt($ch, CURLOPT_POST, true);
            }else{
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            }

            $headers = ['Accept:application/json'];

            if($method != 'GET'){
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
                $headers[] = 'Content-Type:application/json';
            }

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_CAINFO, ini_get('openssl.cafile'));
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip');  // Needed by API

            $response = curl_exec($ch);

            $curl_info = curl_getinfo($ch);

            if(preg_match('/^2\d\d$/',$curl_info['http_code']) !== 1){
                throw new \Exception("Error occurred with http status ".$curl_info['http_code']." !! Response is ". $response);
            }

            curl_close($ch);
            return $response;
        }catch(\Exception $e){
            die($e->getMessage());
        }        
    }
}