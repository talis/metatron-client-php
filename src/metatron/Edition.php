<?php

namespace metatron;
require_once 'common.php';

class Edition {

    public function loadFromArray(array $editionData)
    {
        foreach($editionData as $key => $value)
        {
            $this->{$key} = $value;
        }
    }

    public function getContributorNames()
    {
        $contributors = array();
        if(isset($this->contributors))
        {
            foreach($this->contributors as $c)
            {
                if(isset($c['name']))
                {
                    $contributors[] = $c['name'];
                }
            }
        }
        return $contributors;
    }
}