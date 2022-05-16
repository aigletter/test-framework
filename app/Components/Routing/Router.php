<?php

namespace Aigletter\App\Components\Routing;

use Aigletter\Contracts\Routing\RouteInterface;

class Router implements RouteInterface
{
    protected $actions = [];

    public function addRoute(string $path, $action)
    {
        $path = trim($path, '/');
        $this->actions[$path] = $action;
    }

    public function route(string $uri): callable
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $path = trim($path, '/');
        if (isset($this->actions[$path])) {
            $action = $this->actions[$path];
            if (is_callable($action)) {
                return $action;
            }

            if (is_array($action) && count($action) === 2) {
                $controllerName = $action[0];
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    $method = $action[1];
                    if (method_exists($controller, $method)) {
                        return function () use ($controller, $method) {
                            //$callback = [$controller, $method];
                            $reflectionMethod = new \ReflectionMethod($controller, $method);
                            $arguments = $this->resolveParameters($reflectionMethod);
                            // Определяет метод, который будет вызываться и анализирует его
                            //$callback();
                            $reflectionMethod->invokeArgs($controller, $arguments);
                        };
                    }
                }
            }
        }

        throw new \Exception('Route not found');
    }

    protected function resolveParameters($reflectionMethod)
    {
        $arguments = [];
        foreach ($reflectionMethod->getParameters() as $parameter) {
            $name = $parameter->getName();
            $type = $parameter->getType();
            if ($type && !$type->isBuiltin()) {
                $className = $type->getName();
                $value = new $className();
            } else {
                if (!isset($_GET[$name])) {
                    continue;
                }
                $value = $_GET[$name];
                if ($type && $type->getName() !== gettype($value)) {
                    settype($value, $type->getName());
                }
            }
            $arguments[$name] = $value;
        }

        return $arguments;
    }
}