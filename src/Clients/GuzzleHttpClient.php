<?php

namespace SainsburysCrawler\Clients;

use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $requestOptions;

    /**
     * GuzzleHttpClientAdapter constructor.
     * @param Client $client
     * @param array $requestOptions
     */
    public function __construct(Client $client, array $requestOptions)
    {
        $this->client = $client;
        $this->requestOptions = $requestOptions;
    }

    /**
     * @param $url
     * @return string
     */
    public function doRequest($url)
    {
        $response = $this->client->request('GET', $url, $this->requestOptions);

        $responseBody = $response->getBody();

        return $responseBody->getContents();
    }

}