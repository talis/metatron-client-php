<?php

namespace metatron;
require_once 'common.php';

class WorksResponse extends Response {
    /**
     * @var \metatron\Work[]
     */
    protected $works;
    protected $query;
    /**
     * @var array
     */
    protected $searchParams = array();
    public function loadFromJson($jsonDoc)
    {
        $response = json_decode($jsonDoc, true);

        // Set the services used in response
        if(isset($response['service']))
        {
            $this->services = $response['service'];
        }

        if(isset($response['results']))
        {
            if(isset($response['results']['total']))
            {
                $this->total = $response['results']['total'];
            }
            if(isset($response['results']['limit']))
            {
                $this->limit = $response['results']['limit'];
            }
            if(isset($response['results']['offset']))
            {
                $this->offset = $response['results']['offset'];
            }

            if(isset($response['results']['query']))
            {
                $this->query = $response['results']['query'];
            }
            foreach($response['results']['hits'] as $hit)
            {
                $work = new Work($this->client);
                $work->loadFromArray($hit);
                $this->works[] = $work;
            }
        }
    }

    public function next()
    {
        if(($this->offset + $this->limit) >= $this->total)
        {
            return false;
        }
        $service = $this->searchParams[SERVICE_KEY];

        $service[SEARCH_PREFIX . '.' . SEARCH_OFFSET] = $this->offset + $this->limit;
        return $this->client->getWorksFromTitleAuthor($this->searchParams[TITLE_KEY], $this->searchParams[AUTHOR_KEY], $service);
    }

    /**
     * @return array
     */
    public function getSearchParams()
    {
        return $this->searchParams;
    }

    /**
     * @param array $searchParams
     */
    public function setSearchParams($searchParams)
    {
        $this->searchParams = $searchParams;
    }

    /**
     * @return \metatron\Work[]
     */
    public function getWorks()
    {
        return $this->works;
    }
}