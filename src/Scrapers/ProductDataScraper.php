<?php

namespace SainsburysCrawler\Scrapers;

use SainsburysCrawler\Scrapers\Utils\HtmlScraper;

class ProductDataScraper implements PageScraper
{
    const TITLE_CSS_SELECTOR = '.productTitleDescriptionContainer h1';
    const DESCRIPTION_CSS_SELECTOR = '#information .productText';
    const UNIT_PRICE_CSS_SELECTOR = '.pricePerUnit';

    const UNIT_PRICE_PREFIX_LAST_POSITION = 2;

    /**
     * @var HtmlScraper
     */
    private $htmlScraper;

    /**
     * ProductDataScraper constructor.
     * @param HtmlScraper $htmlScraper
     */
    public function __construct(HtmlScraper $htmlScraper)
    {
        $this->htmlScraper = $htmlScraper;
    }

    /**
     * @param string $html
     * @return array
     */
    public function scrap($html)
    {
        $this->htmlScraper->clear();
        $this->htmlScraper->add($html);

        $product = [];

        $product['title'] = $this->getTitle();
        $product['size'] = $this->getSize($html);
        $product['description'] = $this->getDescription();
        $product['unit_price'] = $this->getUnitPrice();

        return $product;
    }

    /**
     * @return string
     */
    private function getTitle() {
        $titleFilter = $this->htmlScraper->filter(self::TITLE_CSS_SELECTOR);

        return $titleFilter->text();
    }

    /**
     * @param string $html
     * @return string
     */
    private function getSize($html) {
        return $this->parseSizeInKb(
            $this->calculateSizeInKb($html)
        );
    }

    /**
     * @param string $html
     * @return string
     */
    private function calculateSizeInKb($html) {
        return strlen($html) / 1024;
    }

    /**
     * @param float $sizeInKb
     * @return string
     */
    private function parseSizeInKb($sizeInKb) {
        return round($sizeInKb, 1) . 'kb';
    }

    /**
     * @return string
     */
    private function getDescription() {
        $descriptionFilter = $this->htmlScraper->filter(self::DESCRIPTION_CSS_SELECTOR);

        return trim($descriptionFilter->text());
    }

    /**
     * @return float
     */
    private function getUnitPrice()
    {
        $unitPriceNode = $this->htmlScraper->filter(self::UNIT_PRICE_CSS_SELECTOR)->getNode(0);

        $unitPrice = $unitPriceNode->firstChild->nodeValue;

        return $this->parseUnitPrice($unitPrice);
    }

    /**
     * @param string $unitPrice
     * @return float
     */
    private function parseUnitPrice($unitPrice)
    {
        $unitPrice = trim($unitPrice);

        $unitPrice = substr($unitPrice, self::UNIT_PRICE_PREFIX_LAST_POSITION);

        return number_format($unitPrice, 2);
    }
}