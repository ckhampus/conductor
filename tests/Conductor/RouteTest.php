<?php

use Conductor\Route;

class RouteTest extends PHPUnit_Framework_TestCase {
    public function testRoute()
    {
        $r1 = new Route('GET', '/hello', function() {});
        
        $this->assertEquals('GET', $r1->getMethod());
        $this->assertEquals('/hello', $r1->getPath());
        
        $r1->setName('hello');
        
        $this->assertEquals('hello', $r1->getName());

        $r2 = new Route('GET', '/hello/:name', function($name) {});

        $this->assertEquals('/hello/:name', $r2->getPath());
        $this->assertEquals('/hello/cristian', $r2->getPath(array('cristian')));
    }

    public function testRouteMatching()
    {
        $r1 = new Route('GET', '/hello', function() {});

        $this->assertTrue($r1->matchRoute('/hello'));
        $this->assertFalse($r1->matchRoute('/world'));
        
        $r2 = new Route('GET', '/hello/:name', function($name) {});

        $this->assertTrue($r2->matchRoute('/hello/cristian'));
        $this->assertFalse($r2->matchRoute('/gello/cristian'));
    }
}
