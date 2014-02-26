<?php

namespace metatron;

class Edition {
    /**
     * @var \metatron\client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(\metatron\Client &$client)
    {
        $this->client = $client;
    }

    public function loadFromArray(array $editionData)
    {
        foreach($editionData as $key => $value)
        {
            $this->{$key} = $value;
        }
    }

}