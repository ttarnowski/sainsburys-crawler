<?php

use SainsburysCrawler\Tasks\CrawlGroceryProductListPage;

include dirname(__FILE__) . '/../tasks/CrawlGroceryProductListPage.php';

echo (new CrawlGroceryProductListPage())->run();