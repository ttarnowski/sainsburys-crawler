<?php

namespace SainsburysCrawler\Scrapers\Utils;

interface HtmlScraper
{
    /**
     * @param \DOMNodeList|\DOMNode|array|string|null $node A node
     */
    public function add($node);

    /**
     * @param string $selector A CSS selector
     * @return HtmlScraper A new instance of HtmlScraper with the filtered list of nodes
     */
    public function filter($selector);

    /**
     * @return HtmlScraper A HtmlScraper instance with the children nodes
     */
    public function children();

    /**
     * @return \ArrayIterator
     */
    public function getIterator();

    /**
     * @param int $position
     * @return \DOMElement|null
     */
    public function getNode($position);

    /**
     * @return string The node value
     */
    public function text();

    /**
     * @return void
     */
    public function clear();
}