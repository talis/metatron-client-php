<?php

require_once 'TestBase.php';

class WorksResponseTest extends TestBase
{
    public function testLoadFromJson()
    {
        $json = file_get_contents(dirname(__DIR__) . '/unit/fixtures/abstract-algebra.works.json');
        $response = new \metatron\WorksResponse($this->getDummyClient());
        $response->loadFromJson($json);

    }
}