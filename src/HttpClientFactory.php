<?php

namespace SainsburysScraper;

use GuzzleHttp\Client;
use SainsburysScraper\Adapters\GuzzleHttpClient;

class HttpClientFactory
{
    /**
     * @var array
     */
    static private $guzzleHttpClientConfiguration = [
        'allow_redirects' => true,
        'headers' => [
            'User-Agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
        ]
    ];

    /**
     * @return GuzzleHttpClient
     */
    static public function createGuzzleHttpClient() {
        return new GuzzleHttpClient(new Client(), self::$guzzleHttpClientConfiguration);
    }
}