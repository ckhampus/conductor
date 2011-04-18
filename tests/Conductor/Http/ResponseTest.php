<?php

use Conductor\Http;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    public function testAddingCookies()
    {
        $res = new Response();

        $cookies1 = array('cookie_name' => 'cookie_value');
        $cookies2 = array('cookie_value');

        $this->assertTrue($res->addCookies($cookies1));
        $this->assertFalse($res->addCookies($cookies2));
    }

    public function testSettingCookies()
    {
        $res = new Response();
    }

    public function testGettingCookies()
    {
        $res = new Response();
    }
}
