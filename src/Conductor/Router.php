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

use Conductor\Route;
use Conductor\RouteCollection;

/**
 * Handles request and dispatches them to the right routes. 
 *
 * @package Conductor
 * @author  Cristian Hampus <contact@cristianhampus.se>
 */
class Router
{
    private $_routes;
    private $_requested_path;
    
    /**
     * Create a new router for handling requests. 
     * 
     * @param RouteCollection $routes Collection of routes to initialize the router with.
     *
     * @access protected
     * @return void
     */
    function __construct(RouteCollection $routes = null) 
    {
        $this->_routes = (is_null($routes)) ? new RouteCollection() : $routes;
    }
    
    /**
     * Add a route object to the router. 
     * 
     * @param Route  $route The route object to add.
     * @param string $name  The to associate the route with.
     *
     * @return void
     */
    public function add(Route $route, $name = null) 
    {
        $this->_routes->add($route, $name);   
    }

    /**
     * Get the RouteCollection with all the routes. 
     * 
     * @return Route
     */
    public function getRoutes()
    {
        return $this->_routes;
    }
    
    /**
     * Dispatches request to correct route. 
     * 
     * @return void
     */
    public function dispatch() 
    {
        $this->_requested_path = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : '/';

        foreach ($this->_routes as $route) {
            if ($route->getMethod() === $_SERVER['REQUEST_METHOD']) {
                if ($route->matchRoute($this->_requested_path)) {
                    call_user_func_array(
                        $route->getCallback(),
                        $this->_getParameters($route->getPath())
                    );
                
                    return true;
                }
            }
        }

        return false;
    }
    
    /**
     * Return the parameters from the specified paths. 
     * 
     * @param string $path The path to get the parameters from.
     *
     * @return array
     */
    private function _getParameters($path)
    {
        return array_diff(explode('/', $this->_requested_path), explode('/', $path));
    }
}
