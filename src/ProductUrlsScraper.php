<?php

namespace SainsburysScraper;

use SainsburysScraper\Interfaces\HtmlScraper;
use SainsburysScraper\Interfaces\PageScraper;

class ProductUrlsScraper implements PageScraper
{
    const PRODUCT_CSS_SELECTOR = '.product';
    const PRODUCT_URL_CSS_SELECTOR = 'h3 a';

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
     * @return \ArrayIterator
     */
    public function scrap($html)
    {
        $this->htmlScraper->clear();
        $this->htmlScraper->add($html);

        return $this->getProductUrls();
    }

    /**
     * @return \ArrayIterator
     */
    private function getProductUrls()
    {
        $urls = new \ArrayIterator();

        foreach ($this->getUrlNodeElements() as $urlElement) {
            $hrefAttributeNode = $urlElement->attributes->getNamedItem('href');

            $urls->append($hrefAttributeNode->nodeValue);
        }

        return $urls;
    }

    /**
     * @return \ArrayIterator
     */
    private function getUrlNodeElements()
    {
        $productFilter = $this->htmlScraper->filter(self::PRODUCT_CSS_SELECTOR);

        $productsCrawler = $productFilter->children();

        $productUrlFilter = $productsCrawler->filter(self::PRODUCT_URL_CSS_SELECTOR);

        return $productUrlFilter->getIterator();
    }
}