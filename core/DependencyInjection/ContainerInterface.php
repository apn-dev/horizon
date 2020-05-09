<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 25/09/18
 * Time: 19:33
 */

namespace Core\DependencyInjection;


interface ContainerInterface
{
    public function get($key);
    public function set($key, callable $callable);
}