<?php

namespace Conductor;

use Conductor\Base;
use Conductor\Route;

/**
 * Collection object for routes.
 * 
 * @author Cristian Hampus
 */
class RouteCollection extends Base implements Iterator, Countable {
    private $position = 0;
    private $count = 0;
    private $routes = array();
    
    public function add(Route $route) {
        $this->routes = $route;
        $this->count = count($this->routes);
    }
    
    /**
     * Count the number of routes in the collection.
     *
     * @return int
     */
    public function count() {
        return $this->count;   
    }
    
    public function current() {
        return $this->routes[$this->position];
    }
    
    public function key() {
        return $this->position;
    }
    
    public function next() {
        ++$this->position;   
    }
    
    public function rewind() {
        $this->position = 0;   
    }
    
    public function valid() {
        return isset($this->routes[$this->position]);   
    }
}