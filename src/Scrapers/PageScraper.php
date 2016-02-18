<?php

namespace SainsburysCrawler\Scrapers;

interface PageScraper
{
    /**
     * @param string $html
     * @return mixed
     */
    public function scrap($html);
}