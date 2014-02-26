<?php

namespace metatron;

class Edition {

    public function loadFromArray(array $editionData)
    {
        foreach($editionData as $key => $value)
        {
            $this->{$key} = $value;
        }
    }

}