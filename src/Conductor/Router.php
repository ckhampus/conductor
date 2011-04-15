<?php

namespace Conductor;

use Conductor\Base;
use Conductor\Route;
use Conductor\RouteCollection;

class Router extends Base {
    private $routes;
    private $requested_path
    
    function __construct(RouteCollection $routes = NULL) {
        $this->routes = (is_null($routes)) ? new RouteCollection() : $routes;
        $this->requested_path = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : '/';
        
        $this->readableProperties('routes');
    }
    
    public function add(Route $route) {
        $this->routes->add($route);   
    }
    
    public function dispatch() {
        foreach ($this->routes as $route) {
            if ($route->getMethod() === $_SERVER['REQUEST_METHOD']) {
                if ($route->matchRoute($this->requested_path)) {
                    call_user_func_array($route->getCallback(),
                        $this->getArguments($route->getPath()));
                }
            }
        }
    }
    
    private function getArguments($path)
    {
        return array_diff(explode('/', $this->requested_path), explode('/', $path));
    }
}