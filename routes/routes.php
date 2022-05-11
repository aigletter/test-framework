<?php

/**
 * @var \Aigletter\App\Components\Routing\Router $router
 */

$router->addRoute('/', function () {
    echo 'Callback is running<br>';
});

$router->addRoute('product/view', [\Aigletter\App\Controllers\ProductController::class, 'view']);
$router->addRoute('product/test', [\Aigletter\App\Controllers\ProductController::class, 'test']);