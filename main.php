<?php

// An example of using php-webdriver.
// Do not forget to run composer install before. You must also have Selenium server started and listening on port 4444.

namespace BLIS;

use Facebook\WebDriver\Firefox\FirefoxDriver;

require_once('vendor/autoload.php');
require_once('test/blis.php');

$driver = FirefoxDriver::start();

try { 
    $blis = new BLIS("http://localhost:8080/", $driver);
    $blis->login("testlab1_admin", "admin123");

    echo "Tabs:\n";
    foreach($blis->navTabs() as $tab) {
        echo "-> ".$tab->getText()."\n";
    }
} finally {
    $driver->quit();
}
