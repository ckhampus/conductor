<?php

namespace Conductor;

/**
 * Contains information about a route.
 * 
 * @package Conductor
 * @author Cristian Hampus <contact@cristianhampus.se>
 */
class Route 
{
    private $method;
    private $path;
    private $callback;
    private $name;
    
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
        $this->method = strtoupper($method);
        $this->path = $path;
        $this->callback = $callback;
    }

    /**
     * Returns the number of parameters the path accepts. 
     * 
     * @return int
     */
    private function hasParameters()
    {
        return count($this->getParameterNames());
    }

    /**
     * Get the names of the parameters specified in the path.
     *
     * @return array
     */
    private function getParameterNames()
    {
        $matches = array();
        $regexp = '/:[a-zA-Z_][a-zA-Z0-9_]*/';
        preg_match_all($regexp, $this->path, $matches);

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
        return (bool)preg_match('/^'.$this->getPathWithData().'$/', $path);
    }

    /**
     * Get the method 
     * 
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get the path with or without parameter data. 
     * 
     * @param array $data Array containing data to insert into the path.
     *
     * @return string
     */
    public function getPath(Array $data = array())
    {
        if (empty($data)) {
            return $this->path;
        } else {
            return $this->getPathWithData($data);
        }
    }

    /**
     * Get the callback. 
     * 
     * @return callback
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Get the path with parameter data. 
     * 
     * @param array $data Array containing data to insert into the path.
     * @return string
     */
    private function getPathWithData(Array $data = array())
    {
        if (empty($data)) {
            // If data array is empty replace
            // parameters in path with regular expression
            $path = str_replace('/', '\/', $this->path);
            $data = array_fill_keys($this->getParameterNames(), '[\w]+');
        } else {
            // If data array is not empty replace
            // parameters with data from array.
            
            // Check if the expected number of
            // parameters in the data array is right.
            if ($this->hasParameters() < count($data)) {
                throw new \Exception(
                    sprintf(
                        'Expecting %s parameter%s.',
                        $this->hasParameters(),
                        (($this->hasParameters() === 1) ? '' : 's')
                    )
                );
            }
            
            $path = $this->path;
            $data = array_combine($this->getParameterNames(), $data);
        }

        foreach ($data as $key => $value) {
            $path = str_replace($key, $value, $path);
        }

        return $path;
    }
}
