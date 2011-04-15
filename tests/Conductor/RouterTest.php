<?php

use Conductor\Route;
use Conductor\Router;

class RouterTest extends PHPUnit_Framework_TestCase {
    public function testAddingRoutesToRouter() {

        $r = new Router();

        $this->assertEquals(0, count($r->getRoutes()));
        
        $r->add(new Route('GET', '/', function() {}));
        $r->add(new Route('GET', '/hello', function() {}));
        $r->add(new Route('GET', '/world', function() {}));

        $this->assertEquals(3, count($r->getRoutes()));
        
    }

    public function testRouteDispatcher()
    {
        $r = new Router();

        $r->add(new Route('GET', '/', function() {}));
        $r->add(new Route('GET', '/hello/:name', function($name) {}));
        $r->add(new Route('GET', '/world', function() {}));

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/hello';

        $this->assertFalse($r->dispatch());
        
        $_SERVER['PATH_INFO'] = '/hello/cristian';

        $this->assertTrue($r->dispatch());
        
        $_SERVER['PATH_INFO'] = '/world';

        $this->assertTrue($r->dispatch());
    }
}
