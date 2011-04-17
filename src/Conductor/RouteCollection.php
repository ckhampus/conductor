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
 * Collection object for routes.
 * 
 * @package Conductor
 * @author  Cristian Hampus <contact@cristianhampus.se>
 */
class RouteCollection implements \Iterator, \Countable, \ArrayAccess
{
    private $_end = false;
    private $_routes = array();
    
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
      
        $this->_routes[$name] = $route;
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
        return isset($this->_routes[$name]) ? $this->_routes[$name] : null;
    }
    
    /**
     * Count the number of routes in the collection.
     *
     * @return int
     */
    public function count() 
    {
        return count($this->_routes);  
    }
    
    /**
     * Return the current element. 
     * 
     * @return Route
     */
    public function current() 
    {
        return current($this->_routes);
    }
    
    /**
     * Return the key of the current element.
     * 
     * @return mixed
     */
    public function key() 
    {
        return key($this->_routes);
    }
    
    /**
     * Move forward to the next element.
     * 
     * @return void
     */
    public function next() 
    {
        $next = next($this->_routes);

        if ($next === false) {
            $this->_end = true;
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
        $this->_end = false;
        reset($this->_routes);   
    }
    
    /**
     * Checks if the current position is valid. 
     * 
     * @return bool
     */
    public function valid() 
    {
        return !$this->_end;
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
        return isset($this->_routes[$name]) ? $this->_routes[$name] : null;
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
        return isset($this->_routes[$name]);
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
        unset($this->_routes[$name]);
    }
}
