<?php

namespace Conductor\Http;

/**
 * 
 **/
class Request
{
    
    function __construct()
    {
        
    }

    public function addCookies(array $cookies)
    {
        // code...  
    }

    public function addHeaders(array $headers)
    {
        // code...  
    }

    public function addPostFields(array $post_data)
    {
        // code...  
    }

    public function addPostFile($name, $file, $content_type = 'application/x-octetstream')
    {
        // code...  
    }

    public function addPutData($put_data)
    {
        // code...  
    }

    public function addQueryData(array $query_params)
    {
        // code...  
    }

    public function addRawPostData($raw_post_data)
    {
        // code...  
    }

    public function addSslOptions(array $options)
    {
        // code...  
    }
    
    public function enableCookies()
    {
        // code...
    }

    public function getContentType()
    {
        // code...
    }

    public function getCookies()
    {
        // code...
    }

    public function getHeaders()
    {
        // code...
    }

    public function getMethod()
    {
        // code...  
    }

    public function getOptions()
    {
        // code...  
    }

    public function getPostFields()
    {
        // code...
    }

    public function getPostFiles()
    {
        // code...  
    }

    public function getPutData()
    {
        // code...  
    }

    public function getPutFile()
    {
        // code...  
    }

    public function getQueryData()
    {
        // code...  
    }

    public function getRawPostData()
    {
        // code...
    }

    public function getResponseBody()
    {
        // code...  
    }

    public function getResponseCode()
    {
        // code...  
    }

    public function getResponseCookies()
    {
        // code...  
    }

    public function getResponseHeader()
    {
        // code...  
    }

    public function getResponseInfo()
    {
        // code...  
    }

    public function getResponseMessage()
    {
        // code...
    }

    public function getResponseStatus()
    {
        // code...  
    }

    public function getSslOptions()
    {
        // code...  
    }

    public function getUrl()
    {
        // code...  
    }

    public function resetCookies()
    {
        // code...  
    }

    public function send()
    {
        // code...  
    }
}
