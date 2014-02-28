<?php

require_once 'TestBase.php';

class EditionTest extends TestBase
{
    public function testLoadFromArray()
    {
        $data = json_decode(file_get_contents(dirname(__DIR__) . '/unit/fixtures/9781419345333.editions.json'), true);
        $edition = new \metatron\Edition();
        $edition->loadFromArray($data['requested']);

        // Test methods
        $this->assertEquals(array('Albert Camus', 'Jonathan Davis'), $edition->getContributorNames());

        // Test attributes set from data
        $this->assertEquals('9781419345333', $edition->identifier);
        $this->assertEquals('nielsen', $edition->source);
        $this->assertEquals('Stranger', $edition->title);
        $this->assertEquals('xxu', $edition->country);
        $this->assertEquals("2013-09-11T10:46:22.057Z", $edition->created_at);
        $this->assertEquals("2013-09-11T10:46:22.057Z", $edition->updated_at);
        $this->assertEquals("04", $edition->publishing_status);
        $this->assertEquals("stranger/camus", $edition->work_id);
        $this->assertEquals("The Stranger", $edition->full_title);

        $this->assertEquals(array('isbn'=>array("9781419345333")), $edition->identifiers);
        $this->assertEquals(array('leading_article'=>'The'), $edition->other_titles);

        $this->assertCount(2, $edition->contributors);
        $this->assertEquals('A01', $edition->contributors[0]['role']);
        $this->assertEquals('person', $edition->contributors[0]['type']);
        $this->assertEquals('df6f525fb50c7c903b4a88a89dfc176b', $edition->contributors[0]['key_string']);
        $this->assertEquals(array('surname'=>'Camus','first_name'=>'Albert'), $edition->contributors[0]['name_parts']);
        $this->assertEquals('Albert Camus', $edition->contributors[0]['name']);

        $this->assertEquals('E07', $edition->contributors[1]['role']);
        $this->assertEquals('person', $edition->contributors[1]['type']);
        $this->assertEquals('18ce9d51c7dd4f5a4e36132b9d7dcd29', $edition->contributors[1]['key_string']);
        $this->assertEquals(array('surname'=>'Davis','first_name'=>'Jonathan'), $edition->contributors[1]['name_parts']);
        $this->assertEquals('Jonathan Davis', $edition->contributors[1]['name']);

        $this->assertEquals(array('published'=>"2005-12-01T00:00:00.000Z"), $edition->dates);

        $this->assertEquals(array('AB'), $edition->format);

        $this->assertEquals(array('name'=>'Recorded Books', 'imprint'=>'Recorded Books'), $edition->publisher);
    }
}
