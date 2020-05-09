<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 02/12/18
 * Time: 04:27
 */

namespace Core\Controller;


use Core\Router\Router;

interface ControllerInterface
{
    public function addRoutes(Router $router);
}