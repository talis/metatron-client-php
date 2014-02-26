<?php


class ClientTest extends PHPUnit_Framework_TestCase {
    public function testClientEndpointInitialization()
    {
        $client = new \metatron\Client('http://example.com');
        $this->assertEquals('http://example.com', $client->getServiceBaseUrl());
        $client->setServiceBaseUrl('http://example.org');
        $this->assertEquals('http://example.org', $client->getServiceBaseUrl());
    }

    public function testFoo()
    {
        $location = getenv('METATRON_BASEURL');
        $client = new \metatron\Client($location);
        $r = $client->getEditionsFromIsbn('9780818504280');
        var_dump($r);
    }


}