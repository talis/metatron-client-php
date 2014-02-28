<?php

require_once 'TestBase.php';

class ClientTest extends TestBase {
    public function testClientEndpointInitialization()
    {
        $client = new \metatron\Client('http://example.com');
        $this->assertEquals('http://example.com', $client->getServiceBaseUrl());
        $client->setServiceBaseUrl('http://example.org');
        $this->assertEquals('http://example.org', $client->getServiceBaseUrl());
    }

    public function testGetEditionsFromIsbn()
    {
        $serverResponse = array(200, null, file_get_contents(dirname(__DIR__) . '/unit/fixtures/9781419345333.editions.json'));
        /** @var \metatron\Client $client */
        $client = $this->getDummyClientWithCannedResponses(array($serverResponse));
        $response = $client->getEditionsFromIsbn('9781419345333');
        $this->assertInstanceOf('metatron\EditionsResponse', $response);
        $this->assertEquals(array(\metatron\SERVICE_EDITIONS), $response->getServices());
    }

    public function testGetEditionsFromIsbnLanguageFilter()
    {
        $serverResponse = array(200, null, file_get_contents(dirname(__DIR__) . '/unit/fixtures/9784102114018.editions.language.json'));
        /** @var \metatron\Client $client */
        $client = $this->getDummyClientWithCannedResponses(array($serverResponse));
        $filters = array(\metatron\FILTERS_PREFIX . '.' . \metatron\FILTERS_LANGUAGE => 'true');
        $response = $client->getEditionsFromIsbn('9784102114018', $filters);
        $this->assertInstanceOf('metatron\EditionsResponse', $response);
        $this->assertEquals(array(\metatron\SERVICE_EDITIONS), $response->getServices());
        $this->assertEquals(array(\metatron\FILTERS_LANGUAGE => 'jpn'), $response->getFilters());
    }

//    public function testGetEditionsFromIsbnEditionsFilter()
//    {
//          TODO: metatron currently bombing on this
//    }

    public function testGetWorksFromTitleAuthor()
    {
        $serverResponse = array(200, null, file_get_contents(dirname(__DIR__) . '/unit/fixtures/abstract-algebra.works.json'));
        /** @var \metatron\Client $client */
        $client = $this->getDummyClientWithCannedResponses(array($serverResponse));
        $response = $client->getWorksFromTitleAuthor('First Course in Abstract Algebra', 'Fraleigh');
        $this->assertInstanceOf('metatron\WorksResponse', $response);
        $this->assertContains(\metatron\SERVICE_WORKS, $response->getServices());
        $this->assertContains(\metatron\SERVICE_SEARCH, $response->getServices());
        $this->assertArrayHasKey(\metatron\TITLE_KEY, $response->getSearchParams());
        $this->assertArrayHasKey(\metatron\AUTHOR_KEY, $response->getSearchParams());
        $this->assertArrayHasKey(\metatron\SERVICE_KEY, $response->getSearchParams());
        $searchParams = $response->getSearchParams();
        $this->assertEquals('First Course in Abstract Algebra', $searchParams[\metatron\TITLE_KEY]);
        $this->assertEquals(array(\metatron\SERVICE_KEY=>\metatron\SERVICE_WORKS), $searchParams[\metatron\SERVICE_KEY]);
    }
}