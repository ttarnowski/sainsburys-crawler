<?php

namespace SainsburysCrawler;

use SainsburysCrawler\Interfaces\HttpClient;

class GroceryPageCrawler
{

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var ProductUrlsScraper
     */
    private $productUrlsScraper;

    /**
     * @var ProductDataScraper
     */
    private $productDataScraper;

    /**
     * ScrapGroceryPageCommand constructor.
     * @param HttpClient $httpClient
     * @param ProductUrlsScraper $productUrlsScraper
     * @param ProductDataScraper $productDataScraper
     */
    public function __construct(
        HttpClient $httpClient,
        ProductUrlsScraper $productUrlsScraper,
        ProductDataScraper $productDataScraper
    )
    {
        $this->httpClient = $httpClient;
        $this->productUrlsScraper = $productUrlsScraper;
        $this->productDataScraper = $productDataScraper;
    }

    /**
     * @param string $groceryListPageUrl
     * @return string Json string
     */
    public function crawl($groceryListPageUrl)
    {
        $products = $this->getProducts($groceryListPageUrl);
        $total = $this->calculateTotalPrice($products);

        return $this->convertToJson($products, $total);
    }

    /**
     * @param string $groceryListPageUrl
     * @return array
     */
    private function getProducts($groceryListPageUrl)
    {
        $products = [];
        foreach ($this->getUrls($groceryListPageUrl) as $url) {
            $productDataPageHtml = $this->httpClient->doRequest($url);

            $product = $this->productDataScraper->scrap($productDataPageHtml);

            $products[] = $product;
        }

        return $products;
    }

    /**
     * @param string $groceryListPageUrl
     * @return \ArrayIterator
     */
    private function getUrls($groceryListPageUrl)
    {
        $productListPageHtml = $this->httpClient->doRequest($groceryListPageUrl);

        return $this->productUrlsScraper->scrap($productListPageHtml);
    }

    /**
     * @param array $products
     * @return float
     */
    private function calculateTotalPrice(array $products)
    {
        return array_reduce($products, function ($totalPrice, $product) {
            $totalPrice += $product['unit_price'];

            return $totalPrice;
        });
    }

    /**
     * @param array $products
     * @param float $total
     * @return string Json pretty formatted string
     */
    private function convertToJson(array $products, $total)
    {
        $results = array_values($products);

        return json_encode([
            'results' => $results,
            'total' => $total,
        ], JSON_PRETTY_PRINT);
    }
}