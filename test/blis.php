<?php

namespace BLIS;

use Exception;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class BLIS {
    private $baseurl;
    private $driver;

    function __construct($baseurl, $driver) {
        $this->baseurl = $baseurl;
        $this->driver = $driver;

        $this->driver->get($this->baseurl);
    }

    function login($username, $password) {
        if (!$this->isOnHome()) {
            throw new Exception("Not on home page. Current URL: ".$this->driver->getCurrentURL());
        }

        echo "Logging in as $username...\n";

        $form = $this->driver->findElement(WebDriverBy::id('form_login'));

        $form->findElement(WebDriverBy::id('username'))
             ->sendKeys($username);
        $form->findElement(WebDriverBy::id('password'))
             ->sendKeys($password);
        $form->submit();

        echo "Attempted to log in...\n";

        $this->driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('globalnav'))
        );

        return $this;
    }

    function navTabs() {
        return $this->driver
            ->findElement(WebDriverBy::id('globalnav'))
            ->findElements(WebDriverBy::tagName('a'));
    }

    private function isOnHome() {
        return str_ends_with($this->driver->getCurrentURL(), "login.php");
    }
}