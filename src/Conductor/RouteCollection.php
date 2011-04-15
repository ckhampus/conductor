<?php

namespace Conductor;

use Conductor\Base;
/**
 * Collection object for routes.
 * 
 * @author Cristian Hampus
 */
class RouteCollection extends Base implements Iterator, Countable {
    private $position = 0;
    private $routes = array();
    
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