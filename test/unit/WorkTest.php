<?php

require_once 'TestBase.php';
class WorkTest extends TestBase{
    public function testLoadFromArray()
    {

        $data = json_decode(file_get_contents(dirname(__DIR__) . '/unit/fixtures/abstract-algebra.works.json'), true);
        $work = new \metatron\Work($this->getDummyClient());
        $work->loadFromArray($data['results']['hits'][0]);

        // Test attributes set from data
        $this->assertEquals("first_course_in_abstract_algebra/fraleigh", $work->identifier);
        $this->assertEquals('nielsen', $work->source);
        $this->assertEquals("first course in abstract algebra john b. fraleigh", $work->citation);
        $this->assertEquals("First Course in Abstract Algebra", $work->norm_title);
        $this->assertEquals("John B. Fraleigh", $work->fauthor);
        $this->assertTrue($work->is_referenced);
        $this->assertEquals(
            array(
                "isbn"=>array("9780201528213", "9780321156082", "9780201335965", "9780201474367", "9780201592917", "9780201763904", "9780201020847", "9780201168471", "9780201104066", "9780321390363", "9780201019841", "9780201023411", "9781428833920")
            ), $work->identifiers
        );

        // TODO: test $work->getEditions when can get to metatron
    }
}