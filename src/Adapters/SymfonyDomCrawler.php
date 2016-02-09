<?php

namespace SainsburysCrawler\Adapters;

use SainsburysCrawler\Interfaces\HtmlScraper;
use Symfony\Component\DomCrawler\Crawler;

class SymfonyDomCrawler extends Crawler implements HtmlScraper
{
}