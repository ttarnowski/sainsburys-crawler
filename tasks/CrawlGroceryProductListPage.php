<?php

namespace SainsburysCrawler\Tasks;

use SainsburysCrawler\Clients\HttpClientFactory;
use SainsburysCrawler\GroceryPageCrawler;
use SainsburysCrawler\Scrapers\ProductDataScraper;
use SainsburysCrawler\Scrapers\ProductUrlsScraper;
use SainsburysCrawler\Scrapers\Utils\SymfonyHtmlScraperAdapter;

include dirname(__FILE__) . '/../vendor/autoload.php';

class CrawlGroceryProductListPage
{
    const SAINSBURYS_GROCERY_PRODUCT_LIST_PAGE = 'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html';

    public function run()
    {
        $htmlScraper = new SymfonyHtmlScraperAdapter();

        $crawler = new GroceryPageCrawler(
            HttpClientFactory::createGuzzleHttpClient(),
            new ProductUrlsScraper($htmlScraper),
            new ProductDataScraper($htmlScraper)
        );

        return $crawler->crawl(self::SAINSBURYS_GROCERY_PRODUCT_LIST_PAGE);
    }
}