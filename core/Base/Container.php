<?php

namespace Aigletter\Framework\Base;

use Aigletter\Framework\Exceptions\GetComponentException;

abstract class Container
{
    protected $bindings;

    protected function __construct(array $bindings)
    {
        $this->bindings = $bindings;
    }

    public function __get(string $name)
    {
        return $this->getComponent($name);
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement __call() method.
    }

    /**
     * Метод создает с помощью фабрики экземпляр сервиса...
     *
     * @param string $key Ключ, под которым зарегистрирован сервис
     * @return mixed
     * @throws GetComponentException
     */
    public function getComponent($key)
    {
        if (isset($this->bindings[$key])) {
            if (isset($this->bindings[$key]['factory'])) {
                return $this->makeByFactory($key);
            }

            if (isset($this->bindings[$key]['class'])) {
                return $this->makeObject($this->bindings[$key]['class'], $this->bindings[$key]['arguments'] ?? []);
            }
        }

        /*$class = $this->config['components'][$key]['class'];
        if (class_exists($class)) {
            $instance = new $class();
            return $instance;
        }*/


        throw new GetComponentException('Component not found');
    }

    protected function makeByFactory($key)
    {
        $factoryClass = $this->bindings[$key]['factory'];
        $arguments = $this->bindings[$key]['arguments'] ?? [];
        $factory = new $factoryClass($arguments);
        $instance = $factory->createComponent();
        return $instance;
    }

    public function makeObject(string $class, $options = []): object
    {
        $reflectionClass = new \ReflectionClass($class);

        $dependencies = $this->resolveDependencies($class, '__construct', $options);
        $instance = $reflectionClass->newInstanceArgs($dependencies);

        return $instance;
    }

    public function resolveDependencies($class, $method, $options = [])
    {
        $reflectionClass = new \ReflectionClass($class);
        $dependencies = [];
        if ($reflectionClass->hasMethod($method)) {
            $method = $reflectionClass->getMethod($method);
            foreach ($method->getParameters() as $parameter) {
                $name = $parameter->getName();
                $type = $parameter->getType();
                if ($type && !$type->isBuiltin()) {
                    $dependencies[$name] = $this->getComponent($type->getName());
                } else {
                    $dependencies[$name] = $options[$name] ?? null;
                }
            }
        }

        return $dependencies;
    }
}