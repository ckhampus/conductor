<?php

namespace Conductor;

/**
 * Collection object for routes.
 * 
 * @package Conductor
 * @author Cristian Hampus <contact@cristianhampus.se>
 */
class RouteCollection implements \Iterator, \Countable
{
    private $position = 0;
    private $count = 0;
    private $routes = array();
    
    /**
     * Add route object to the collection.
     * 
     * @param Route  $route The route object to add.
     * @param string $name  Name to assign the route with.
     *
     * @return void
     */
    public function add(Route $route, $name = null) 
    {
        if (is_null($name)) {
            $this->routes[] = $route;
        } else {
            $this->routes[$name] = $route;
        }
        
        $this->count = count($this->routes);
    }
    
    /**
     * Get route object by name. 
     * 
     * @param string $name The name of the route.
     *
     * @return Route
     */
    public function getRouteByName($name) 
    {
        return (isset($this->routes[$name])) ? $this->routes[$name] : null;
    }
    
    /**
     * Count the number of routes in the collection.
     *
     * @return int
     */
    public function count() 
    {
        return $this->count;   
    }
    
    /**
     * Return the current element. 
     * 
     * @return Route
     */
    public function current() 
    {
        return $this->routes[$this->position];
    }
    
    /**
     * Return the key of the current element.
     * 
     * @return mixed
     */
    public function key() 
    {
        return $this->position;
    }
    
    /**
     * Move forward to the next element.
     * 
     * @return void
     */
    public function next() 
    {
        ++$this->position;   
    }
    
    /**
     * Rewind the Iterator to the first element. 
     * 
     * @return void
     */
    public function rewind() 
    {
        $this->position = 0;   
    }
    
    /**
     * Checs of current position is valid. 
     * 
     * @return bool
     */
    public function valid() 
    {
        return isset($this->routes[$this->position]);   
    }
}
