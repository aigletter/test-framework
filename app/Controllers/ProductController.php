<?php

namespace Aigletter\App\Controllers;

use Aigletter\App\Components\Math\MathInterface;
use Aigletter\Framework\Application;
use Psr\Log\LoggerInterface;

class ProductController
{
    public function view(int $id)
    {
        echo '<h1>Product ' . $id . '</h1>';

        /** @var LoggerInterface $logger */
        $logger = Application::getApp()->getComponent('logger');
        $logger->debug('Start show method');

        $math = Application::getApp()->getComponent(MathInterface::class);
        $math->sum(3, 6);
    }

    public function test($name, $value)
    {
        echo '<h1>Test ' . $name . ', ' . $value . '</h1>';
    }
}