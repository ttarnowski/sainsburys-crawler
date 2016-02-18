<?php

namespace SainsburysCrawler\Scrapers;

use SainsburysCrawler\Scrapers\Utils\HtmlScraper;

use ArrayIterator;

class ProductUrlsScraper implements PageScraper
{
    const PRODUCT_URLS_CSS_SELECTOR = '.product h3 a';

    /**
     * @var HtmlScraper
     */
    private $htmlScraper;

    /**
     * @param HtmlScraper $htmlScraper
     */
    public function __construct(HtmlScraper $htmlScraper) {
        $this->htmlScraper = $htmlScraper;
    }

    /**
     * @param \DOMNodeList|\DOMNode|array|string|null $html
     * @return ArrayIterator
     */
    public function scrap($html)
    {
        $this->htmlScraper->clear();
        $this->htmlScraper->add($html);

        return $this->getProductUrls();
    }

    /**
     * @return ArrayIterator
     */
    private function getProductUrls()
    {
        $urls = new ArrayIterator();

        foreach ($this->getUrlNodeElements() as $urlElement) {
            $hrefAttributeNode = $urlElement->attributes->getNamedItem('href');

            $urls->append($hrefAttributeNode->nodeValue);
        }

        return $urls;
    }

    /**
     * @return ArrayIterator
     */
    private function getUrlNodeElements()
    {
        $productUrlsFilter = $this->htmlScraper->filter(self::PRODUCT_URLS_CSS_SELECTOR);

        return $productUrlsFilter->getIterator();
    }
}