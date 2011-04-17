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
 
namespace Conductor;

/**
 * Contains information about a route.
 * 
 * @package Conductor
 * @author  Cristian Hampus <contact@cristianhampus.se>
 */
class Route
{
    private $_method;
    private $_path;
    private $_callback;
    
    /**
     * Create a new route object.
     * 
     * @param string   $method   The HTTP request method.
     * @param string   $path     The path to match the request against.
     * @param callback $callback The callback to invoke on request.
     *
     * @return void
     */
    public function __construct($method, $path, $callback) 
    {
        $this->_method = strtoupper($method);
        $this->_path = $path;
        $this->_callback = $callback;
    }

    /**
     * Returns the number of parameters the path accepts. 
     * 
     * @return int
     */
    private function _hasParameters()
    {
        return count($this->_getParameterNames());
    }

    /**
     * Get the names of the parameters specified in the path.
     *
     * @return array
     */
    private function _getParameterNames()
    {
        $matches = array();
        $regexp = '/:[a-zA-Z_][a-zA-Z0-9_]*/';
        preg_match_all($regexp, $this->_path, $matches);

        return $matches[0];
    }

    /**
     * Matches the route against the specified path. 
     * 
     * @param string $path The path to match the route against.
     *
     * @return bool
     */
    public function matchRoute($path)
    {
        return (bool)preg_match('/^'.$this->_getPathWithData().'$/', $path);
    }

    /**
     * Get the method 
     * 
     * @return string
     */
    public function getMethod()
    {
        return $this->_method;
    }

    /**
     * Get the path with or without parameter data. 
     * 
     * @param array $data Array containing data to insert into the path.
     *
     * @return string
     */
    public function getPath(array $data = array())
    {
        if (empty($data)) {
            return $this->_path;
        } else {
            return $this->_getPathWithData($data);
        }
    }

    /**
     * Get the callback. 
     * 
     * @return callback
     */
    public function getCallback()
    {
        return $this->_callback;
    }

    /**
     * Get the path with parameter data. 
     * 
     * @param array $data Array containing data to insert into the path.
     *
     * @return string
     */
    private function _getPathWithData(array $data = array())
    {
        if (empty($data)) {
            // If data array is empty replace
            // parameters in path with regular expression
            $path = str_replace('/', '\/', $this->_path);
            $data = array_fill_keys($this->_getParameterNames(), '[\w]+');
        } else {
            // If data array is not empty replace
            // parameters with data from array.
            
            // Check if the expected number of
            // parameters in the data array is right.
            if ($this->_hasParameters() > count($data)) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Expecting %s parameter%s.',    // Error message
                        $this->_hasParameters(),         // Number of parameters
                        (($this->_hasParameters() === 1) ? '' : 's') // Plural?
                    )
                );
            }
            
            $path = $this->_path;
            $data = array_combine($this->_getParameterNames(), $data);
        }

        foreach ($data as $key => $value) {
            $path = str_replace($key, $value, $path);
        }

        return $path;
    }
}
