<?php

namespace Conductor;

use Conductor\Route;
use Conductor\RouteCollection;

/**
 * Handles request and dispatches them to the right routes. 
 *
 * @package Conductor
 * @author Cristian Hampus <contact@cristianhampus.se>
 */
class Router {
    private $routes;
    private $requested_path;
    
    /**
     * Create a new router for handling requests. 
     * 
     * @param RouteCollection $routes 
     * @access protected
     * @return void
     */
    function __construct(RouteCollection $routes = NULL) {
        $this->routes = (is_null($routes)) ? new RouteCollection() : $routes;
    }
    
    /**
     * Add a route object to the router. 
     * 
     * @param Route $route 
     * @return void
     */
    public function add(Route $route) {
        $this->routes->add($route);   
    }

    /**
     * Get the RouteCollection with all the routes. 
     * 
     * @return Route
     */
    public function getRoutes()
    {
        return $this->routes;
    }
    
    /**
     * Dispatches request to correct route. 
     * 
     * @return void
     */
    public function dispatch() {

        $this->requested_path = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : '/';

        foreach ($this->routes as $route) {
            if ($route->getMethod() === $_SERVER['REQUEST_METHOD']) {
                if ($route->matchRoute($this->requested_path)) {
                    call_user_func_array($route->getCallback(),
                        $this->getParameters($route->getPath()));
                
                    return TRUE;
                }
            }
        }

        return FALSE;
    }
    
    /**
     * Return the parameters from the specified paths. 
     * 
     * @param string $path 
     * @return array
     */
    private function getParameters($path)
    {
        return array_diff(explode('/', $this->requested_path), explode('/', $path));
    }
}
