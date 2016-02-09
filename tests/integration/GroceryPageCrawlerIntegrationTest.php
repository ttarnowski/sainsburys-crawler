<?php

namespace SainsburysCrawler;

use SainsburysCrawler\Interfaces\HttpClient;

class GroceryPageCrawlerIntegrationTest extends \PHPUnit_Framework_TestCase
{
    private $crawler;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $httpClient;

    public function setUp()
    {
        $this->httpClient = $this->getMockForAbstractClass(HttpClient::class);
        $htmlScraper = new Adapters\SymfonyDomCrawler();

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
        $mainUrl = 'http://www.sainsburys.co.uk/shop/gb/groceries/fruit-veg/ripe---ready';
        $this->httpClient
            ->expects($this->any())
            ->method('doRequest')
            ->willReturnMap([
                [$mainUrl, $this->getProductListFixture()],
                ['http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-avocado-xl-pinkerton-loose-300g', $this->getProductFixture(1)],
                ['http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-avocado--ripe---ready-x2', $this->getProductFixture(2)],
                ['http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-avocados--ripe---ready-x4', $this->getProductFixture(3)],
                ['http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-conference-pears--ripe---ready-x4-%28minimum%29', $this->getProductFixture(4)],
            ]);

        $actualJsonResult = $this->crawler->crawl($mainUrl);

        $this->assertEquals($expectedJsonResult, $actualJsonResult);
    }
}