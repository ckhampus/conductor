<?php

use Conductor\Route;

class RouteTest extends PHPUnit_Framework_TestCase {
    public function testRoute()
    {
        // Create a new route
        $r1 = new Route('GET', '/hello', function() {});
        
        // Get the route method and path
        $this->assertEquals('GET', $r1->getMethod());
        $this->assertEquals('/hello', $r1->getPath());
        
        // Get the route name before assignment
        $this->assertEquals(NULL, $r1->getName());
        
        // Give the route a name
        $r1->setName('hello');
        
        // Get the route name after assignment
        $this->assertEquals('hello', $r1->getName());
    }
    
    public function testRouteWithData() {
        // Create a new route with parameter in path
        $r1 = new Route('GET', '/hello/:name', function($name) {});

        // Get the path with and without parameters data
        $this->assertEquals('/hello/:name', $r1->getPath());
        $this->assertEquals('/hello/cristian', $r1->getPath(array('cristian')));
    }

    public function testRouteMatching() {
        // Create a new route
        $r1 = new Route('GET', '/hello', function() {});

        // Match the route against a valid and invalid path
        $this->assertTrue($r1->matchRoute('/hello'));
        $this->assertFalse($r1->matchRoute('/world'));
    }
    
    public function testRouteMatchingWithData() {
        // Create a new route with parameter in path
        $r1 = new Route('GET', '/hello/:name', function($name) {});

        // Match the route against a valid and invalid path
        $this->assertTrue($r1->matchRoute('/hello/cristian'));
        $this->assertFalse($r1->matchRoute('/gello/cristian'));
    }
}
