<?php

namespace SainsburysScraper;

use SainsburysScraper\Adapters\GuzzleHttpClient;

class HttpClientFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function test_createGuzzleHttpClient_returns_GuzzleHttpClientAdapter()
    {
        $httpClient = HttpClientFactory::createGuzzleHttpClient();

        $this->assertInstanceOf(GuzzleHttpClient::class, $httpClient);
    }
}