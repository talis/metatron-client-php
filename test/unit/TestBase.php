<?php

abstract class TestBase extends PHPUnit_Framework_TestCase
{
    protected function getDummyClient()
    {
        return $this->getMock('\metatron\Client', array('getHttpClient'), array('http://example.com/'));
    }

    protected function getDummyClientWithCannedResponses(array $responses)
    {
        $httpClient = new \Guzzle\Http\Client("http://example.com/");
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $resp = new ReflectionClass('\Guzzle\Http\Message\Response');
        foreach($responses as $response)
        {
            $plugin->addResponse($resp->newInstanceArgs($response));
        }
        $httpClient->addSubscriber($plugin);
        $client = $this->getDummyClient();
        $client->expects($this->atLeastOnce())->method('getHttpClient')->will($this->returnValue($httpClient));
        return $client;
    }

}