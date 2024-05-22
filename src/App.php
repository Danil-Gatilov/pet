<?php

namespace App;
use App\container\Container;

class App
{
    public function run(): void
    {
        $container = new Container();

        $container->router->dispatch($container->request->server('REQUEST_METHOD'), $container->request->uri());
    }
}