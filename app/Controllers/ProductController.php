<?php

namespace Aigletter\App\Controllers;

class ProductController
{
    public function view(int $id)
    {
        echo '<h1>Product ' . $id . '</h1>';
    }

    public function test($name, $value)
    {
        echo '<h1>Test ' . $name . ', ' . $value . '</h1>';
    }
}