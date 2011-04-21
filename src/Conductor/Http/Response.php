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
 * 
 * @package Conductor
 * @author  Cristian Hampus <contact@cristianhampus.se>
 */
class Response
{
    private $_headers = array();
    private $_cookies = array();
    private $_charset = 'utf-8';
    private $_content = null;
    private $_status  = null;
    
    function __construct()
    {
        // code...
    }
    
    /**
     * Get previously set cookies.
     * 
     * @return array
     */
    public function getCookies() {
        return $this->_cookies;   
    }

    /**
     * Add cookies to response.
     * 
     * @param array $cookies Associative array containing cookie name/value pairs to add.
     *
     * @return bool
     */
    public function addCookies(array $cookies)
    {
        if (!is_assoc_array($cookies)) {
            return false;   
        }
        
        $this->_cookies = array_merge($this->_cookies, $cookies);
        
        return true;
    }

    /**
     * Set cookies 
     * 
     * @param array $cookies Associative array containing cookie name/value pairs to add.
     *
     * @return bool
     */
    public function setCookies(array $cookies)
    {
        if (!is_assoc_array($cookies)) {
            return false;   
        }
        
        $this->_cookies = $cookies;
        
        return true;
    }

    /**
     * Get previously set headers. 
     * 
     * @return array
     */
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

    /**
     * Set header field.
     * 
     * @param string $name  Name of the header field.
     * @param mixed  $value The value to set.
     *
     * @return void
     */
    public function setHeader($name, $value)
    {
        $this->addHeaders(array((string)$name => $value));
    }

    /**
     * Get header field. 
     * 
     * @param string $name Name of the header field.
     *
     * @return void
     */
    public function getHeader($name)
    {
        return isset($this->_headers[$name]) ? $this->_headers[$name] : null;
    }

    /**
     * Get currently set charset. 
     * 
     * @return string
     */
    public function getCharset()
    {
        return $this->_charset;
    }

    /**
     * Set the charset.  
     * 
     * @param string $charset The charset to set.
     *
     * @return void
     */
    public function setCharset($charset)
    {
        $this->_charset = $charset;
    }

    /**
     * Get the content type. 
     * 
     * @return string
     */
    public function getContentType()
    {
        return $this->getHeader('Content-Type');
    }

    /**
     * Set content type. 
     * 
     * @param string $type The content type.
     *
     * @return void
     */
    public function setContentType($type)
    {
        $this->setHeader('Content-Type', $type);
    }

    /**
     * Specify an attachment. 
     * 
     * @param string $filename Optionally set the filename for the attachment. 
     *
     * @return void
     */
    public function setAttachment($filename = null)
    {
        $this->_headers['Content-Disposition'] = 'attachment';
        
        if (!is_null($filename)) {
            $this->_headers['Content-Disposition'] .= '; filename='.$filename;
        }
    }

    /**
     * Set status code for the response. 
     * 
     * @param int $status The HTTP status code.
     *
     * @return void
     */
    public function setStatusCode($status)
    {
        $this->_status = $status;
    }

    /**
     * Set a file to be downloaded. 
     * 
     * @param mixed $file Path to the file to be downloaded.
     *
     * @return bool
     */
    public function download($file)
    {
        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
        $this->setContentType(finfo_file($fileinfo, $file));

        $this->_content = file_get_contents($file);
        
        if ((bool)$this->_content) {
            $this->send();
        }

        return (bool)$this->_content;
    }

    /**
     * Send the response. 
     * 
     * @param string $content The body to send in the request.
     *
     * @return void
     */
    public function send($content = null)
    {
        foreach ($this->_headers as $key => $value) {
            header(sprintf('%s: %s', $key, $value));
        }

        if (!is_null($this->_status)) {
            header(sprintf('HTTP/1.1 %s', $this->_status));
        }

        echo $this->_content;
    }

    /**
     * Redirect to url. 
     * 
     * @param string $url    Url to redirect to.
     * @param int    $status The status code to send.
     *
     * @return void
     */
    public function redirect($url, $status = 302)
    {
        $this->setStatusCode($status);
        $this->setHeader('Location', $url);
        $this->send();
    }
}
