<?php

namespace Aigletter\App\Controllers;

use Aigletter\Framework\Application;
use Psr\Log\LoggerInterface;

class ShopController
{
    public function __construct()
    {
        $cache = Application::getApp()->getComponent('cache');
        $cache->set('hello', 'Hello world!!!!');
    }

    public function show()
    {
        /** @var LoggerInterface $logger */
        $logger = Application::getApp()->getComponent('logger');
        $logger->debug('Start show method');

        $cached = Application::getApp()->getComponent('cache')->get('hello');
        echo 'Shop controller show method. Cached value: ' . $cached . '<br>';

        $logger->debug('Got value from cache', [
            'cached_value' => $cached
        ]);

        echo Application::getApp()->getComponent('test')->sayHello();

        $logger->debug('Finish show method');
    }
}