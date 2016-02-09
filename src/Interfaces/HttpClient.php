<?php

namespace SainsburysScraper\Interfaces;

interface HttpClient
{
    /**
     * @param $url
     * @return string
     */
    public function doRequest($url);

}