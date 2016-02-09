<?php

namespace SainsburysScraper;

use SainsburysScraper\Interfaces\HtmlScraper;
use SainsburysScraper\Interfaces\PageScraper;

class ProductDataScraper implements PageScraper
{
    const UNIT_PRICE_PREFIX_LAST_POSITION = 4;

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
        $product['size'] = $this->calculateSizeInKb($html);
        $product['description'] = $this->getDescription();
        $product['unit_price'] = $this->getUnitPrice();

        return $product;
    }

    /**
     * @return string
     */
    private function getTitle() {
        $titleFilter = $this->htmlScraper->filter('.productTitleDescriptionContainer h1');

        return $titleFilter->text();
    }

    /**
     * @param string $html
     * @return string
     */
    private function calculateSizeInKb($html) {
        $sizeInKb = strlen($html) / 1024;

        return round($sizeInKb, 2) . 'kb';
    }

    /**
     * @return string
     */
    private function getDescription() {
        $descriptionFilter = $this->htmlScraper->filter('#information .productText');

        return trim($descriptionFilter->text());
    }

    /**
     * @return float
     */
    private function getUnitPrice()
    {
        $unitPrice = $this->htmlScraper->filter('.pricePerUnit')->getNode(0);

        return $this->parseUnitPrice($unitPrice);
    }

    /**
     * @param string $unitPrice
     * @return float
     */
    private function parseUnitPrice($unitPrice)
    {
        $unitPrice = trim($unitPrice->firstChild->nodeValue);

        $unitPrice = substr($unitPrice, self::UNIT_PRICE_PREFIX_LAST_POSITION);

        return round((float) $unitPrice, 2);
    }
}