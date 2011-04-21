<?php

use Conductor\Http\Response;

class ResponseTest extends PHPUnit_Extensions_OutputTestCase
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
    
    public function testAddingHeaders()
    {
        $res = new Response();

        $headers1 = array('Content-Type' => 'text/html');
        $headers2 = array('text/html');

        $this->assertTrue($res->addHeaders($headers1));
        $this->assertFalse($res->addHeaders($headers2));
    }

    public function testSettingHeaders()
    {
        $res = new Response();
        
        $headers1 = array('Content-Type' => 'text/html');
        $headers2 = array('text/html');

        $this->assertTrue($res->setHeaders($headers1));
        $this->assertFalse($res->setHeaders($headers2));
    }

    public function testGettingHeaders()
    {
        $res = new Response();
        
        $headers1 = array(
            'Content-Type' => 'text/html',
            'Content-Length' => '1337'
        );

        $this->assertTrue($res->addHeaders($headers1));
        $this->assertEquals(2, count($res->getHeaders()));
        
        $headers2 = array('Proxy-Authenticate' => 'Basic');
        
        $this->assertTrue($res->addHeaders($headers2));
        $this->assertEquals(3, count($res->getHeaders()));
        
        $this->assertEquals(array_merge($headers1, $headers2), $res->getHeaders());
        
        $headers3 = array(
            'Content-Encoding' => 'gzip'    
        );
        
        $this->assertTrue($res->setHeaders($headers3));
        $this->assertEquals(1, count($res->getHeaders()));
        $this->assertEquals($headers3, $res->getHeaders());        
    }

    public function testSettingAndGettingContentType()
    {
        $res = new Response();

        $this->assertEquals(null, $res->getContentType());

        $res->setContentType('text/html');

        $this->assertEquals('text/html', $res->getContentType());
    }

    public function testSettingAndGettingCharset()
    {
        $res = new Response();

        $this->assertEquals('utf-8', $res->getCharset());
        
        $res->setCharset('ISO-8859-1');

        $this->assertEquals('ISO-8859-1', $res->getCharset());
    }

    public function testSettingAttachment()
    {
        $res = new Response();

        $res->setAttachment();

        $this->assertEquals('attachment', $res->getHeader('Content-Disposition'));

        $res->setAttachment('awesome_file.pdf');

        $this->assertEquals('attachment; filename=awesome_file.pdf', $res->getHeader('Content-Disposition'));
    }

    public function testSettingFile()
    {
        $res = new Response();

        $this->assertTrue($res->download(__DIR__.'/../../file.txt'));
        $this->assertEquals('text/plain', $res->getContentType());
    }

    public function testSendingResponse()
    {
        $res = new Response();
        
        $this->expectOutputString("Hello, World!\n");
        $this->assertTrue($res->download(__DIR__.'/../../file.txt'));
        $this->assertEquals('text/plain', $res->getContentType());

    }

    public function testSettingRedirect()
    {
        $res = new Response();

        $res->redirect('/path');

        $this->assertEquals('/path', $res->getHeader('Location'));
    }
}
