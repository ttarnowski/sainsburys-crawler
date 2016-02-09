<?php

namespace SainsburysScraper\Adapters;

use SainsburysScraper\Interfaces\HtmlScraper;
use Symfony\Component\DomCrawler\Crawler;

class SymfonyDomCrawler extends Crawler implements HtmlScraper
{
}