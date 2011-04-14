<?php

namespace Conductor;

use Conductor\Base;

/**
 * Contains information about a route.
 * 
 * @author Cristian Hampus 
 */
class Route extends Base {
    private $method;
    private $path;
    private $callback;
    private $name;

    public function __construct($method, $path, $callback) {
        $this->method = $method;
        $this->path = $path;
        $this->callback = $callback;

        $this->readableProperties('method', 'path', 'name');
        $this->writableProperties('name');
    }

    /**
     * Returns the number of parameters the path accepts. 
     * 
     * @return mixed
     */
    private function hasParameters()
    {
        $count = count($this->getParameterNames());
        return ($count > 0) ? $count : FALSE;
    }

    private function getParameterNames()
    {
        $matches = array();
        $regexp = '/:[a-zA-Z_][a-zA-Z0-9_]*/';
        preg_match_all($regexp, $this->path, $matches);

        return $matches[0];
    }

    /**
     * Mathes the route against the specified path. 
     * 
     * @param string $path 
     * @return bool
     */
    public function matchRoute($path)
    {
        return (bool)preg_match('/^'.$this->getPathWithData().'$/', $path);
    }

    public function getPath(Array $data = array())
    {
        if (empty($data)) {
            return $this->path;
        } else {
            return $this->getPathWithData($data);
        }
    }

    private function getPathWithData(Array $data = array())
    {
        if (empty($data)) {
            $path = str_replace('/', '\/', $this->path);
            $data = array_fill_keys($this->getParameterNames(), '[\w]+');
        } else {
            $path = $this->path;
            $data = array_combine($this->getParameterNames(), $data);
        }

        foreach ($data as $key => $value) {
            $path = str_replace($key, $value, $path);
        }

        return $path;
    }
}
