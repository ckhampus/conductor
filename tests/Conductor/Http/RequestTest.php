<?php

use Conductor\Http\Request;

class RequestTest extends PHPUnit_Framework_TestCase
{
     public function testAddingCookie()
     {
         $r = new Request();

         $c1 = array('hello' => 'world');

         $this->assertTrue($r->addCookies($c1));

         $c2 = array('random_value');

         $this->assertFalse($r->addCookies($c2));
     }
     
     public function testAddingHeaders()
     {
         $r = new Request();

         $h1 = array('Content-Type' => 'text/html');

         $this->assertTrue($r->addHeaders($h1));

         $h2 = array('random_value');

         $this->assertFalse($r->addHeaders($h2));
     }

     public function testAddingPostFields()
     {
         $r = new Request();

         $p1 = array('hello' => 'world');

         $this->assertTrue($r->addPostFields($p1));

         $p2 = array('random_value');

         $this->assertFalse($r->addPostFields($p2));
     }

}
