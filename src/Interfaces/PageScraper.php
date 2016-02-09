<?php

namespace SainsburysCrawler\Interfaces;

interface PageScraper
{
    /**
     * @param string $html
     * @return mixed
     */
    public function scrap($html);
}