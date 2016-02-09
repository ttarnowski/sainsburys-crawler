<?php

namespace SainsburysCrawler;

use SainsburysCrawler\Adapter\SymfonyDomCrawler;

class ProductDataScraperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ProductUrlsScraper
     */
    private $scraper;

    /**
     * @var string
     */
    private $productPageHtmlFixture;

    public function setUp()
    {
        $this->productPageHtmlFixture = file_get_contents(dirname(__FILE__) . '/fixtures/product.html');

        $htmlScraper = new Adapters\SymfonyDomCrawler();

        $this->scraper = new ProductDataScraper($htmlScraper);
    }

    public function test_scrap_extractsProductDataFromFixtureProperly()
    {
        $expectedDescription = <<<EOF
Avocados
            very delicious
EOF;
        $expectedProduct = [
            'title' => 'Sainsbury\'s Avocado Ripe & Ready XL Loose 300g',
            'size' => $this->calculateExpectedSize(),
            'description' => $expectedDescription,
            'unit_price' => 1.50,
        ];

        $actualProduct = $this->scraper->scrap($this->productPageHtmlFixture);

        $this->assertEquals($expectedProduct, $actualProduct);
    }

    private function calculateExpectedSize() {
        $sizeInBytes = strlen($this->productPageHtmlFixture);
        $sizeInKb = $sizeInBytes / 1024;

        $formattedSize = round($sizeInKb, 2) . 'kb';

        return $formattedSize;
    }
}