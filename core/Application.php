<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 02/12/18
 * Time: 01:57
 */

namespace Core;

use Core\DependencyInjection\Container;
use Core\Router\Router;

class Application
{
    private $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function run()
    {
        $router = $this->container->get(Router::class);
        $router->loadRoutes($this->container);
        $response = $router->dispatch();
        echo $response;
    }
}