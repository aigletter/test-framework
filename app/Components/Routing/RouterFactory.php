<?php

namespace Aigletter\App\Components\Routing;

use Aigletter\Contracts\ComponentFactory;

class RouterFactory extends ComponentFactory
{
    protected function createConcreteComponent()
    {
        $router = new Router();
        include __DIR__ . '/../../../routes/routes.php';

        return $router;
    }
}