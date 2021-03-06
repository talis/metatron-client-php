<?php

namespace metatron;
require_once 'common.php';

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

        // Set the filters used in response
        if(isset($response['filters']))
        {
            $this->filters = $response['filters'];
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
        $this->total = count($this->editions);
        $this->limit = $this->total;
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