<?php

use Conductor\Http\Response;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    public function testAddingCookies()
    {
        $res = new Response();

        $cookies1 = array('cookie_name' => 'cookie value');
        $cookies2 = array('cookie value');

        $this->assertTrue($res->addCookies($cookies1));
        $this->assertFalse($res->addCookies($cookies2));
    }

    public function testSettingCookies()
    {
        $res = new Response();
        
        $cookies1 = array('cookie_name' => 'cookie value');
        $cookies2 = array('cookie value');

        $this->assertTrue($res->setCookies($cookies1));
        $this->assertFalse($res->setCookies($cookies2));
    }

    public function testGettingCookies()
    {
        $res = new Response();
        
        $cookies1 = array(
            'cookie_name' => 'cookie value',
            'another_cookie_name' => 'another cookie value'
        );

        $this->assertTrue($res->addCookies($cookies1));
        $this->assertEquals(2, count($res->getCookies()));
        
        $cookies2 = array('cookie_the_third' => 'the third value');
        
        $this->assertTrue($res->addCookies($cookies2));
        $this->assertEquals(3, count($res->getCookies()));
        
        $this->assertEquals(array_merge($cookies1, $cookies2), $res->getCookies());
        
        $cookies3 = array(
            'everybody_loves_cookies' => 'oh yes, they do!'    
        );
        
        $this->assertTrue($res->setCookies($cookies3));
        $this->assertEquals(1, count($res->getCookies()));
        $this->assertEquals($cookies3, $res->getCookies());        
    }
}
