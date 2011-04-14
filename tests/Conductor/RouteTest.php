<?php

use Conductor\Route;

class RouteTest extends PHPUnit_Framework_TestCase {
    public function testRoute()
    {
        $route = new Route('GET', '/hello', function() {});
        
        $this->assertEquals('GET', $route->getMethod());
        $this->assertEquals('/hello', $route->getPath());
        
        $route->setName('hello');
        
        $this->assertEquals('hello', $route->getName());
    }

    public function testRouteMatching()
    {
        $r1 = new Route('GET', '/hello', function() {});

        $this->assertTrue($r1->matchRoute('/hello'));
        $this->assertFalse($r1->matchRoute('/world'));
    }
}
