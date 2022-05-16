<?php

/**
 * Файл такой-то
 *
 * @version 1.0
 */

namespace Aigletter\Framework;

use Aigletter\Framework\Exceptions\GetComponentException;
use Aigletter\Framework\Interfaces\RouteInterface;
use Aigletter\Framework\Interfaces\RunnableInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * Оновной класс фреймворка. Запускает весь процесс обработки запроса и формирования ответа.
 *
 * Этот класс испеользуется так и сяк.
 * Для того чтобы его использовать нужно сделать то и се.
 * Является сервис-локатором в данной реализации
 * @link https://uk.wikipedia.org/wiki/
 *
 *
 * @author Yurii Orlyk <aigletter@gmail.com>
 * @package Aiggletter\Framework
 *
 * @property CacheInterface $cache
 * @property \Aigletter\Contracts\Routing\RouteInterface $router
 *
 */
class Application implements RunnableInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var Application
     */
    protected static $instance;

    /**
     * Метод получает инстанс синглтона
     *
     * @param array $config
     * @return Application
     */
    public static function getApp(array $config = [])
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    /**
     * @param array $config
     */
    private function __construct(array $config)
    {
        $this->config = $config;
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
        if (isset($this->config['components'][$key]['factory'])) {
            $factoryClass = $this->config['components'][$key]['factory'];
            $arguments = $this->config['components'][$key]['arguments'] ?? [];
            $factory = new $factoryClass($arguments);
            $instance = $factory->createComponent();
            return $instance;
        }
        /*$class = $this->config['components'][$key]['class'];
        if (class_exists($class)) {
            $instance = new $class();
            return $instance;
        }*/


        throw new GetComponentException('Component not found');
    }

    /**
     * В этом методе вызыется метод роутера и определяется маршрут
     * @see \Aigletter\Contracts\Routing\RouteInterface::route()
     *
     * @return mixed
     * @throws GetComponentException
     */
    public function run()
    {
        /** @var RouteInterface $router */
        $router = $this->getComponent('router');
        $action = $router->route($_SERVER['REQUEST_URI']);

        return $action();
    }
}