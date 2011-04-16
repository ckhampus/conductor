<?php

use Conductor\Route;
use Conductor\RouteCollection;

class RouteCollectionTest extends PHPUnit_Framework_TestCase {
    public function testRouteCollection()
    {
        $rc = new RouteCollection();

        $this->assertEquals(0, count($rc));
        
        $r1 = new Route('GET', '/hello', function() {});
        $rc->add($r1);

        $this->assertEquals(1, count($rc));
        
        $r2 = new Route('GET', '/fancy', function() {});
        $rc->add($r2, 'fancy_route');

        $this->assertEquals(2, count($rc));
        $this->assertEquals($r2, $rc->getRouteByName('fancy_route'));
    }

    public function testRouteTraversal()
    {
        $rc = new RouteCollection();

        $r1 = new Route('GET', '/hello', function() {});
        $r2 = new Route('GET', '/world', function() {});
        $rc->add($r1);
        $rc->add($r2);
        
        $this->assertEquals(2, count($rc));     

        $this->assertTrue($rc->valid());
        $this->assertEquals($r1, $rc->current());
        $this->assertEquals('hello', $rc->key());

        $rc->next();

        $this->assertTrue($rc->valid());
        $this->assertEquals($r2, $rc->current());
        $this->assertEquals('world', $rc->key());

        $rc->next();

        $this->assertFalse($rc->valid());
    }
}
