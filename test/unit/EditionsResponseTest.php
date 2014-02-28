<?php

require_once 'TestBase.php';

class EditionsResponseTest extends TestBase {

    public function testLoadFromJson()
    {
        $json = file_get_contents(dirname(__DIR__) . '/unit/fixtures/9781419345333.editions.json');
        $response = new \metatron\EditionsResponse($this->getDummyClient());
        $response->loadFromJson($json);
        $this->assertEquals(array(\metatron\SERVICE_EDITIONS), $response->getServices());
        $this->assertEquals(15, $response->getTotal());
        $this->assertEquals(0, $response->getOffset());
        $this->assertEquals(15, $response->getLimit());
        $this->assertEmpty($response->getFilters());
        $this->assertInstanceOf('\metatron\Edition', $response->getRequestedEdition());
        $editions = $response->getEditions();
        $this->isTrue(is_array($editions));
        $this->assertCount(15, $editions);
        $this->assertContains($response->getRequestedEdition(), $editions);
        foreach($editions as $edition)
        {
            $this->assertInstanceOf('\metatron\Edition', $edition);
        }
    }
}