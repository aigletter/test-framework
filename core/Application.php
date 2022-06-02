<?php

/**
 * Файл такой-то
 *
 * @version 1.0
 */

namespace Aigletter\Framework;

use Aigletter\Framework\Base\Container;
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
class Application extends Container implements RunnableInterface
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
        $bindings = $config['components'] ?? [];
        parent::__construct($bindings);
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