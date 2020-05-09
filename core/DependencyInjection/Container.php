<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 23/09/18
 * Time: 15:38
 */

namespace Core\DependencyInjection;

class Container implements ContainerInterface
{
    private $container = [];
    private $instances = [];

    /**
     * @param $key
     * @param callable $callable
     */
    public function set($key, callable $callable)
    {
        $this->container[$key] = $callable;

        if (!isset($this->instances[$key])) {
            $this->instances[$key] = $callable();
        }
    }

    /**
     * @param $key
     * @return mixed
     * @throws \ReflectionException
     */
    public function get($key)
    {
        if (!$this->container[$key]) {
            $reflection = new \ReflectionClass($key);

            if ($reflection->isInstantiable()) {
                if ($reflection->getConstructor()) {
                    $params = $reflection->getConstructor()->getParameters();
                    $reflectionParameters = [];

                    foreach ($params as $param) {
                        if ($param->getClass()) {
                            $reflectionParameters[] = $this->get($param->getClass()->getName());
                        } else {
                            $reflectionParameters[] = $param;
                        }
                    }

                    if (!$this->instances[$key]) {
                        $this->instances[$key] = $reflection->newInstanceArgs($reflectionParameters);
                    }
                } else {
                    if (!$this->instances[$key]) {
                        $this->instances[$key] = $reflection->newInstance();
                    }
                }
            } else {
                if (!$this->instances[$key]) {
                    $this->instances[$key] = $reflection->newInstance();
                }
            }
        }

        if ($this->instances[$key]) {
            return $this->instances[$key];
        }

        return $this->container[$key]();
    }
}
