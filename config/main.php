<?php

use Aigletter\App\Components\Logging\LoggerFactory;
use Aigletter\App\Components\Math\Math;
use Aigletter\App\Components\Math\MathInterface;
use Aigletter\App\Components\Test\TestFactory;

return [
    'app_name' => 'Test framework',
    'components' => [
        'router' => [
            //'factory' => \Aigletter\Framework\Components\Routing\RouterFactory::class,
            'factory' => \Aigletter\App\Components\Routing\RouterFactory::class,
        ],
        'cache' => [
            'factory' => \Aigletter\Framework\Components\Caching\CacheFactory::class,
            'arguments' => [
                'filename' => __DIR__ . '/../data/cache/cache.json'
            ]
        ],
        'test' => [
            'factory' => TestFactory::class,
        ],
        'logger' => [
            'factory' => LoggerFactory::class,
            'arguments' => [
                LoggerFactory::KEY_FILEPATH => __DIR__ . '/../data/cache',
                LoggerFactory::KEY_FILENAME => 'log.txt',
            ]
        ],
        \Psr\Log\LoggerInterface::class => [
            'factory' => LoggerFactory::class,
            'arguments' => [
                LoggerFactory::KEY_FILEPATH => __DIR__ . '/../data/cache',
                LoggerFactory::KEY_FILENAME => 'log.txt',
            ]
        ],
        MathInterface::class => [
            'class' => Math::class,
            'arguments' => [
                'mode' => 'not_strict'
            ],
        ]
    ]
];