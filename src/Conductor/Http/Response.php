<?php
/**
 * Copyright (c) 2011 Cristian Hampus
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
 
namespace Conductor\Http;

function is_assoc_array(array $arr) {
    foreach ($arr as $key => $value) {
        if (!is_string($key)) {
            return false;   
        }
    }
    
    return true;
}

/**
 * Response
 **/
class Response
{
    private $_headers = array();
    private $_cookies = array();
    private $_charset = 'utf-8';
    private $_content = null;
    
    function __construct()
    {
        // code...
    }
    
    public function getCookies() {
        return $this->_cookies;   
    }

    public function addCookies(array $cookies)
    {
        if (!is_assoc_array($cookies)) {
            return false;   
        }
        
        $this->_cookies = array_merge($this->_cookies, $cookies);
        
        return true;
    }

    public function setCookies(array $cookies)
    {
        if (!is_assoc_array($cookies)) {
            return false;   
        }
        
        $this->_cookies = $cookies;
        
        return true;
    }

    public function getHeaders()
    {
        return $this->_headers;
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
        if (!is_assoc_array($headers)) {
            return false;   
        }
        
        $this->_headers = array_merge($this->_headers, $headers);
        
        return true; 
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
        if (!is_assoc_array($headers)) {
            return false;   
        }
        
        $this->_headers = $headers;
        
        return true; 
    }

    public function setHeader($name, $value)
    {
        $this->addHeaders(array((string)$name => $value));
    }

    public function getHeader($name)
    {
        return isset($this->_headers[$name]) ? $this->_headers[$name] : null;
    }

    public function getCharset()
    {
        return $this->_charset;
    }

    public function setCharset($charset)
    {
        $this->_charset = $charset;
    }

    public function getContentType()
    {
        return $this->getHeader('Content-Type');
    }

    public function setContentType($type)
    {
        $this->setHeader('Content-Type', $type);
    }

    public function setAttachment($filename = null)
    {
        $this->_headers['Content-Disposition'] = 'attachment';
        
        if (!is_null($filename)) {
            $this->_headers['Content-Disposition'] .= '; filename='.$filename;
        }
    }

    public function setFile($file)
    {
        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
        $this->setContentType(finfo_file($fileinfo, $file));

        $this->_content = file_get_contents($file);

        return (bool)$this->_content;
    }

    public function setStatusCode($status)
    {
        // code...  
    }

    public function send($content = null)
    {
        foreach ($this->_headers as $key => $value) {
            header(sprintf('%s: %s', $key, $value));
        }

        echo $this->_content;
    }

    public function redirect($url, $status = 302)
    {
        $this->setHeader('Location', $url);
    }
}
