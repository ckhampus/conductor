<?php

namespace Conductor\Http;

/**
 * Response
 **/
class Response
{

    private $_headers = array();
    private $_cookies = array();
    
    function __construct(argument)
    {
        // code...
    }

    public function addCookies(array $cookies)
    {
        // code...  
    }

    public function setCookies(array $cookies)
    {
        // code...
    }

    public function getHeaders()
    {
        // code...  
    }

    /**
     * Add headers to the response.
     * 
     * @param array $headers Associative array containing header name/value pairs.
     * 
     * @return bool
     */
    public function addHeaders(array $headers)
    {
        // code...  
    }

    /**
     * Set headers for the response. Existing headers will be cleared. 
     * 
     * @param array $headers Associative array containing header name/value pairs.
     *
     * @return bool
     */
    public function setHeaders(array $headers)
    {
        // code...  
    }

    public function addHeader($field, $value)
    {
        // code...  
    }

    public function setHeader($name, $value)
    {
        // code...  
    }

    public function getHeader($name, $value)
    {
        // code...  
    }

    public function getCharset()
    {
        // code...  
    }

    public function setCharset($charset)
    {
        // code...  
    }

    public function getContentType()
    {
        // code...  
    }

    public function setContentType($type)
    {
        // code...  
    }

    public function setAttachement($filename = null)
    {
        $this->_headers['Content-Disposition'] = 'attachment';
        
        if (!is_null($filename)) {
            $this->_headers['Content-Disposition'] .= '; filename='.$filename;
        }
    }

    public function setFile($file)
    {
        // code...  
    }

    public function setStatusCode($status)
    {
        // code...  
    }

    public function send()
    {
        // code...
    }

    public function redirect($url, $status = 302)
    {
        // code...  
    }
}
