<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 30/11/18
 * Time: 21:27
 */

namespace Core\Router;

use Core\DependencyInjection\ContainerInterface;

class Router
{
    private $container;
    private $url;
    private $routes = [];
    private $controllers = [];

    public function __construct()
    {
        $url = $_SERVER["REQUEST_URI"];

        if ('/' === $url) {
            $this->url = $url;
        }

        $this->url = rtrim($url);
    }

    /**
     * @param string $url
     * @param string $class
     * @param string $function
     * @throws \ReflectionException
     */
    public function get(string $url, string $class, string $function)
    {
        $closure = new \ReflectionMethod($class, $function);
        $this->routes['GET'][$url] = $closure->getClosure($this->container->get($class));
    }

    /**
     * @param string $url
     * @param string $class
     * @param string $function
     * @throws \ReflectionException
     */
    public function post(string $url, string $class, string $function)
    {
        $closure = new \ReflectionMethod($class, $function);
        $this->routes['POST'][$url] = $closure->getClosure($this->container->get($class));;
    }

    /**
     * @param string $route
     * @return bool
     */
    public function match(string $route)
    {
        $route = preg_replace('#:([a-zA-Z0-9]+)+#', '([a-zA-Z0-9]+)', $route);
        $regex = preg_match("#^$route$#", $this->url, $urlParameters);
        array_shift($urlParameters);

        if ($regex) {
            if ($urlParameters) {
                return $urlParameters;
            }

            return true;
        }

        return false;
    }

    /**
     * @return mixed
     * @throws RouterException
     */
    public function dispatch()
    {
        foreach ($this->routes[$_SERVER["REQUEST_METHOD"]] as $route => $function) {
            if ($match = $this->match($route)) {
                if (is_array($match)) {
                    return call_user_func_array($function, $match);
                } else {
                    return call_user_func($function);
                }
            }
        }

        throw new RouterException("No route for the url " . $this->url);
    }

    /**
     * @param ContainerInterface $container
     */
    public function loadRoutes(ContainerInterface $container)
    {
        $this->container = $container;

        $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__ . '/../../src/Controller'));
        $files = [];

        foreach ($rii as $file) {
            if ($file->isDir()){
                continue;
            }

            $files[] = ltrim($file->getPathName(), __DIR__ . '/\.\./\.\./src/Controller');
        }

        foreach ($files as $file) {
            $file = str_replace('/', '\\', $file);
            //todo variabiliser le namespace
            $className = "App\\Controller\\$file";
            $this->controllers[$className] = $container->get(rtrim($className, '.php'));
            $this->controllers[$className]->addRoutes($this);
        }
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }
}
