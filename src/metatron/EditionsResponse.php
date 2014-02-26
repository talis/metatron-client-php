<?php

namespace metatron;

class EditionsResponse extends Response {
    /**
     * @var Edition[]
     */
    protected $editions = array();
    /**
     * @var Edition
     */
    protected $requestedEdition;
    public function loadFromJson($jsonDoc)
    {
        $response = json_decode($jsonDoc, true);
        $requestedId = null;
        // Find our requested edition id, if set
        if(isset($response['requested']['identifier']))
        {
            $requestedId = $response['requested']['identifier'];
        }

        // Set the services used in response
        if(isset($response['service']))
        {
            $this->services = $response['service'];
        }

        if(isset($response['editions']))
        {
            foreach($response['editions'] as $editionArray)
            {
                $edition = new Edition($this->client);
                $edition->loadFromArray($editionArray);
                $this->editions[] = $edition;
                if($requestedId && isset($edition->identifier) && $requestedId === $edition->identifier)
                {
                    $this->requestedEdition = &$edition;
                }
            }
        }
    }

    /**
     * @return \metatron\Edition[]
     */
    public function getEditions()
    {
        return $this->editions;
    }

    /**
     * @return \metatron\Edition
     */
    public function getRequestedEdition()
    {
        return $this->requestedEdition;
    }
}