<?php

use SainsburysCrawler\Adapters\SymfonyDomCrawler;
use SainsburysCrawler\GroceryPageCrawler;
use SainsburysCrawler\HttpClientFactory;
use SainsburysCrawler\ProductDataScraper;
use SainsburysCrawler\ProductUrlsScraper;

include dirname(__FILE__) . '/../vendor/autoload.php';

const SAINSBURYS_GROCERY_PRODUCT_LIST_PAGE = 'http://www.sainsburys.co.uk/shop/gb/groceries/fruit-veg/ripe---ready';


$htmlScraper = new SymfonyDomCrawler();

$crawler = new GroceryPageCrawler(
    HttpClientFactory::createGuzzleHttpClient(),
    new ProductUrlsScraper($htmlScraper),
    new ProductDataScraper($htmlScraper)
);

echo $crawler->crawl(SAINSBURYS_GROCERY_PRODUCT_LIST_PAGE);