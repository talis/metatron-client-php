<?php

namespace metatron;

class Client {
    protected $httpClient;
    protected $serviceBaseUrl;

    public function __construct($baseUrl)
    {
        $this->serviceBaseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    public function getServiceBaseUrl()
    {
        return $this->serviceBaseUrl;
    }

    /**
     * @param string $serviceBaseUrl
     */
    public function setServiceBaseUrl($serviceBaseUrl)
    {
        $this->serviceBaseUrl = $serviceBaseUrl;
    }

    /**
     * @return \Guzzle\Http\Client
     */
    protected function getHttpClient()
    {
        if(!isset($this->httpClient))
        {
            $this->httpClient =  new \Guzzle\Http\Client($this->getServiceBaseUrl());
        }
        return $this->httpClient;
    }

    /**
     * @param string $isbn
     * @param array $filters
     * @return EditionsResponse
     */
    public function getEditionsFromIsbn($isbn, $filters = array())
    {
        $filters['service'] = 'editions';
        $kev = $this->createOpenURLKev(array('isbn'=>$isbn), $filters);
        return $this->getEditionsResponseFromKev($kev);
    }

    /**
     * @param string|null $title
     * @param string|null $author
     * @param array $filters
     * @return WorksResponse
     * @throws \InvalidArgumentException
     */
    public function getWorksFromTitleAuthor($title = null, $author = null, $filters = array())
    {
        $filters['service'] = 'works';
        $rft = array();
        if($title)
        {
            $rft['btitle'] = $title;
        }
        if($author)
        {
            $rft['au'] = $author;
        }
        if(empty($rft))
        {
            throw new \InvalidArgumentException('Title or Author must be sent!');
        }
        $kev = $this->createOpenURLKev($rft, $filters);
        $response = $this->getWorksResponseFromKev($kev);
        $response->setSearchParams(array('title'=>$title, 'author'=>$author, 'filters'=>$filters));
        return $response;
    }

    protected function getEditionsResponseFromKev($kev)
    {
        $metatronResponse = $this->getHttpClient()->get("/resolve?" . $kev, array(), array('headers'=>array('Accept' => 'application/json', 'Accept-Language'=>'en')))->send();
        $response = new EditionsResponse($this);
        $response->loadFromJson($metatronResponse->getBody());
        return $response;
    }

    protected function getWorksResponseFromKev($kev)
    {
        $metatronResponse = $this->getHttpClient()->get("/resolve?" . $kev, array(), array('headers'=>array('Accept' => 'application/json', 'Accept-Language'=>'en')))->send();
        $response = new WorksResponse($this);
        $response->loadFromJson($metatronResponse->getBody());
        return $response;
    }

    /**
     * @param array $referentParams
     * @param array $serviceParams
     * @return string
     */
    public function createOpenURLKev(array $referentParams = array(), array $serviceParams = array())
    {
        $kevParams = array();
        foreach($referentParams as $rftKey=>$rftVals)
        {
            // Have to assume arrays *could* be sent
            if(!is_array($rftVals))
            {
                $rftVals = array($rftVals);
            }
            foreach($rftVals as $rft)
            {
                $kevParams[] = 'rft.'. urlencode($rftKey) . '=' . urlencode($rft);
            }
        }
        foreach($serviceParams as $svcKey=>$svcVals)
        {
            // Have to assume arrays *could* be sent
            if(!is_array($svcVals))
            {
                $svcVals = array($svcVals);
            }
            foreach($svcVals as $svc)
            {
                $kevParams[] = 'svc.'. urlencode($svcKey) . '=' . urlencode($svc);
            }
        }
        return implode("&", $kevParams);
    }

}