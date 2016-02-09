<?php

namespace SainsburysCrawler\Adapters;

use GuzzleHttp\Client;

class GuzzleHttpClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $guzzleHttpClient;

    /**
     * @var GuzzleHttpClient
     */
    private $guzzleHttpClientAdapter;

    /**
     * @var array
     */
    private $requestOptions = ['Some request options'];

    public function setUp()
    {
        $this->guzzleHttpClient = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->guzzleHttpClientAdapter = new GuzzleHttpClient($this->guzzleHttpClient, $this->requestOptions);
    }

    public function test_doRequest_makesAGETRequestOnTheGuzzleHttpClient_properly()
    {
        $expectedResponse = 'Some html response';

        $url = 'http://some.url';
        $this->guzzleHttpClient
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->identicalTo('GET'),
                $this->identicalTo($url),
                $this->identicalTo($this->requestOptions)
            )
            ->willReturn(
                $this->prepareGuzzlerHttpClientResponseObject($expectedResponse)
            );

        $actualResponse = $this->guzzleHttpClientAdapter->doRequest($url);

        $this->assertEquals($expectedResponse, $actualResponse);
    }

    /**
     * @param $response
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function prepareGuzzlerHttpClientResponseObject($response)
    {
        $responseBodyObject = $this->getMock('Body', ['getContents']);
        $responseBodyObject
            ->expects($this->any())
            ->method('getContents')
            ->willReturn($response);

        $responseObject = $this->getMock('Response', ['getBody']);
        $responseObject
            ->expects($this->any())
            ->method('getBody')
            ->willReturn($responseBodyObject);

        return $responseObject;
    }
}