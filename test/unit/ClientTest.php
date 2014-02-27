<?php


class ClientTest extends PHPUnit_Framework_TestCase {
    public function testClientEndpointInitialization()
    {
        $client = new \metatron\Client('http://example.com');
        $this->assertEquals('http://example.com', $client->getServiceBaseUrl());
        $client->setServiceBaseUrl('http://example.org');
        $this->assertEquals('http://example.org', $client->getServiceBaseUrl());
    }

    /**
     * Not a unit test -- just confirming that behavior is what I actually want
     */
    public function testEditions()
    {
        $location = getenv('METATRON_BASEURL');
        $client = new \metatron\Client($location);
        $r = $client->getEditionsFromIsbn('9780818504280');
        var_dump($r);
    }

    /**
     * Not a unit test -- just confirming that behavior is what I actually want
     */
    public function testWorks()
    {
        $location = getenv('METATRON_BASEURL');
        $client = new \metatron\Client($location);
        $r = $client->getWorksFromTitleAuthor('Communication as culture: essays on media and society', 'Carey');
        var_dump($r);
        var_dump($r->next());
        $works = $r->getWorks();
        var_dump($works[0]->getEditions());
    }

}