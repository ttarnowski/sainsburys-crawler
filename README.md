# Sainsbury's Grocery Crawler
A console application that scrapes the Sainsbury’s grocery site - Ripe Fruits page and returns a JSON array of all the products on the page.

## Installation

1. Clone [Git repository](https://github.com/ttarnowski/sainsburys-scraper)
2. `cd` into project root directory
3. Run `composer install`

## Usage

Run the following command from the project directory to scrap a page and:

1. see results in console: `./bin/crawl_grocery_product_page`
2. save results in file: `./bin/crawl_grocery_product_page > /your/file/path`

## Packages

##### Dependencies:
1. [guzzlehttp/guzzle](https://packagist.org/packages/guzzlehttp/guzzle)
2. [symfony/dom-crawler](https://packagist.org/packages/symfony/dom-crawler)
3. [symfony/css-selector](https://packagist.org/packages/symfony/css-selector)

##### Dev Dependencies:
4. [phpunit/phpunit](https://packagist.org/packages/phpunit/phpunit)

## Tests

Run the following commands from the project tests directory to:

1. Execute unit tests: `./run_unit_tests`
2. Execute integration tests `./run_integrations_tests`

## Prerequisites

1. You have a version of PHP >= [5.5.9](http://php.net/releases/5_5_9.php)
2. You have installed [Composer](https://getcomposer.org/)