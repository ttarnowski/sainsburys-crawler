<?php

namespace SainsburysCrawler;

use SainsburysCrawler\Clients\HttpClient;
use SainsburysCrawler\Scrapers\ProductDataScraper;
use SainsburysCrawler\Scrapers\ProductUrlsScraper;
use SainsburysCrawler\Scrapers\Utils\SymfonyHtmlScraperAdapter;
use SainsburysCrawler\Tasks\CrawlGroceryProductListPage;

class GroceryPageCrawlerIntegrationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GroceryPageCrawler
     */
    private $crawler;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $httpClient;

    public function setUp()
    {
        $this->httpClient = $this->getMockForAbstractClass(HttpClient::class);
        $htmlScraper = new SymfonyHtmlScraperAdapter();

        $this->crawler = new GroceryPageCrawler(
            $this->httpClient,
            new ProductUrlsScraper($htmlScraper),
            new ProductDataScraper($htmlScraper)
        );
    }

    private function getProductListFixture()
    {
        return file_get_contents(dirname(__FILE__) . '/fixtures/list.html');
    }

    private function getProductFixture($index)
    {
        return file_get_contents(dirname(__FILE__) . '/fixtures/product-'. $index .'.html');
    }

    public function test_execute_returnsCorrectJsonDataScrapedFromSainsburysGroceryProductListPage()
    {
        $expectedJsonResult = file_get_contents(dirname(__FILE__) . '/expectedResult.json');
        $mainUrl = CrawlGroceryProductListPage::SAINSBURYS_GROCERY_PRODUCT_LIST_PAGE;
        $this->httpClient
            ->expects($this->any())
            ->method('doRequest')
            ->willReturnMap([
                [$mainUrl, $this->getProductListFixture()],
                [
                    'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-apricot-ripe---ready-320g.html',
                    $this->getProductFixture(1)
                ],
                [
                    'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-avocado-xl-pinkerton-loose-300g.html',
                    $this->getProductFixture(2)
                ],
                [
                    'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-avocado--ripe---ready-x2.html',
                    $this->getProductFixture(3)
                ],
            ]);

        $actualJsonResult = $this->crawler->crawl($mainUrl);

        $this->assertEquals($expectedJsonResult, $actualJsonResult);
    }
}