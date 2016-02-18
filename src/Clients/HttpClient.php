<?php

namespace SainsburysCrawler\Clients;

interface HttpClient
{
    /**
     * @param $url
     * @return string
     */
    public function doRequest($url);

}