<?php

namespace Conductor;

/**
 * Collection object for routes.
 * 
 * @package Conductor
 * @author  Cristian Hampus <contact@cristianhampus.se>
 */
class RouteCollection implements \Iterator, \Countable, \ArrayAccess
{
    private $end = false;
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
            $name = trim($route->getPath(), '/');
            $name = str_replace('/', '_', $name);
            $name = str_replace(':', '', $name);
        }
      
        $this->routes[$name] = $route;
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
        return isset($this->routes[$name]) ? $this->routes[$name] : null;
    }
    
    /**
     * Count the number of routes in the collection.
     *
     * @return int
     */
    public function count() 
    {
        return count($this->routes);  
    }
    
    /**
     * Return the current element. 
     * 
     * @return Route
     */
    public function current() 
    {
        return current($this->routes);
    }
    
    /**
     * Return the key of the current element.
     * 
     * @return mixed
     */
    public function key() 
    {
        return key($this->routes);
    }
    
    /**
     * Move forward to the next element.
     * 
     * @return void
     */
    public function next() 
    {
        $next = next($this->routes);

        if ($next === false) {
            $this->end = true;
            return false;
        }

        return $next;
    }
    
    /**
     * Rewind the Iterator to the first element. 
     * 
     * @return void
     */
    public function rewind() 
    {
        $this->end = false;
        reset($this->routes);   
    }
    
    /**
     * Checks if the current position is valid. 
     * 
     * @return bool
     */
    public function valid() 
    {
        return !$this->end;
    }

    /**
     * Assigns a route to the specified name.
     * 
     * @param mixed $name  The name to assign the route to.
     * @param mixed $route The route to set.
     *
     * @return void
     */
    public function offsetSet($name, $route)
    {
        if (is_null($name)) {
            $this->add($route);
        } else {
            $this->add($route, $name);
        }
    }

    /**
     * Returns the route with the specified name. 
     * 
     * @param mixed $name The name of the route to retrieve.
     *
     * @return void
     */
    public function offsetGet($name)
    {
        return isset($this->routes[$name]) ? $this->routes[$name] : null;
    }

    /**
     * Checks whether or not an route with the specified name exists. 
     * 
     * @param mixed $name The name to check for.
     *
     * @return void
     */
    public function offsetExists($name)
    {
        return isset($this->routes[$name]);
    }

    /**
     * Unsets the route with the specified name. 
     * 
     * @param mixed $name The name of the route to unset.
     *
     * @return void
     */
    public function offsetUnset($name)
    {
        unset($this->routes[$name]);
    }
}
