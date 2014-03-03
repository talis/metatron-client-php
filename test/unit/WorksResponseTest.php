<?php

require_once 'TestBase.php';

class WorksResponseTest extends TestBase
{
    public function testLoadFromJson()
    {
        $json = file_get_contents(dirname(__DIR__) . '/unit/fixtures/abstract-algebra.works.json');
        $serverResponse = array(200, null, file_get_contents(dirname(__DIR__) . '/unit/fixtures/abstract-algebra.works-offset10.json'));
        /** @var \metatron\Client $client */
        $client = $this->getDummyClientWithCannedResponses(array($serverResponse));
        $response = new \metatron\WorksResponse($client);
        $response->loadFromJson($json);
        $this->assertContains(\metatron\SERVICE_WORKS, $response->getServices());
        $this->assertContains(\metatron\SERVICE_SEARCH, $response->getServices());
        $this->assertCount(2, $response->getServices());
        $this->assertEquals(1663, $response->getTotal());
        $this->assertEquals(0, $response->getOffset());
        $this->assertEquals(10, $response->getLimit());
        $this->assertEquals("{\"query_string\":{\"query\":\"is_referenced:1 AND citation:First Course in Abstract Algebra Fraleigh\"}}", $response->getQuery());
        $works = $response->getWorks();
        $this->assertCount(10, $works);
        $this->assertContainsOnlyInstancesOf('\metatron\Work', $works);
        $this->assertEquals('first_course_in_abstract_algebra/fraleigh', $works[0]->identifier);
        $this->assertEquals('first_course_in_mechanics/lunn', $works[9]->identifier);
        // Not sure if this will eventually be a problem
        $this->assertEmpty($response->getSearchParams());
        $this->assertFalse($response->next());

        $response->setSearchParams(
            array(
                \metatron\TITLE_KEY=>"First Course in Abstract Algebra",
                \metatron\AUTHOR_KEY=>"Fraleigh",
                \metatron\SERVICE_KEY=>array()
            )
        );

        $nextPage = $response->next();
        $this->assertInstanceOf('\metatron\WorksResponse', $nextPage);
        $this->assertContains(\metatron\SERVICE_WORKS, $nextPage->getServices());
        $this->assertContains(\metatron\SERVICE_SEARCH, $nextPage->getServices());
        $this->assertCount(2, $nextPage->getServices());
        $this->assertEquals(1663, $nextPage->getTotal());
        $this->assertEquals(10, $nextPage->getOffset());
        $this->assertEquals(10, $nextPage->getLimit());
        $this->assertEquals("{\"query_string\":{\"query\":\"is_referenced:1 AND citation:First Course in Abstract Algebra Fraleigh\"}}", $nextPage->getQuery());
        $works = $nextPage->getWorks();
        $this->assertCount(10, $works);
        $this->assertContainsOnlyInstancesOf('\metatron\Work', $works);
        $this->assertEquals('first_course_in_statistics/mcclave', $works[0]->identifier);
        $this->assertEquals('first_course_in_continuum_mechanics/fung', $works[9]->identifier);
        $this->assertArrayHasKey(\metatron\TITLE_KEY, $nextPage->getSearchParams());
        $this->assertArrayHasKey(\metatron\AUTHOR_KEY, $nextPage->getSearchParams());
    }
}