<?php

namespace SainsburysCrawler;

class ProductUrlsScraperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ProductUrlsScraper
     */
    private $scraper;

    /**
     * @var string
     */
    private $productListPageHtmlFixture;

    public function setUp()
    {
        $this->productListPageHtmlFixture = file_get_contents(dirname(__FILE__) . '/fixtures/list.html');

        $htmlScraper = new Adapters\SymfonyDomCrawler();

        $this->scraper = new ProductUrlsScraper($htmlScraper);
    }

    public function test_scrap_extractsProductUrlsFromFixtureProperly()
    {
        $expectedUrls = new \ArrayIterator([
            'http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-avocado-xl-pinkerton-loose-300g',
            'http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-avocado--ripe---ready-x2'
        ]);

        $actualUrls = $this->scraper->scrap($this->productListPageHtmlFixture);

        $this->assertEquals($expectedUrls, $actualUrls);
    }
}