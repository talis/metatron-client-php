<?php

namespace metatron;
require_once 'common.php';
abstract class Response {
    /**
     * @var array
     */
    protected $services = array();
    /**
     * @var int
     */
    protected $total = 0;
    /**
     * @var int
     */
    protected $offset = 0;
    /**
     * @var int
     */
    protected $limit = 0;

    /**
     * @var \metatron\Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $filters = array();

    /**
     * @param string $jsonDoc
     * @return void
     */
    abstract function loadFromJson($jsonDoc);

    public function __construct(\metatron\Client $client)
    {
        $this->client = $client;
    }
    /**
     * @return array
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

}