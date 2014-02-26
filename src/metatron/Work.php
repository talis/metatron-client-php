<?php


namespace metatron;

class Work {
    private $client;
    public function __construct(\metatron\Client &$client)
    {
        $this->client = $client;
    }

    public function loadFromArray(array $workData)
    {
        foreach($workData as $key => $value)
        {
            $this->{$key} = $value;
        }
    }

    public function getEditions($filters = array())
    {
        if(isset($this->identifiers['isbn']))
        {
            foreach($this->identifiers['isbn'] as $isbn)
            {
                try
                {
                    return $this->client->getEditionsFromIsbn($isbn, $filters);
                } catch(\Exception $e)
                {
                    // Metatron is very intolerant of ISBNs
                    continue;
                }
            }
        }
    }

}