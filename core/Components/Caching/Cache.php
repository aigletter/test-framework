<?php

namespace Aigletter\Framework\Components\Caching;

use Psr\SimpleCache\CacheInterface;

class Cache implements CacheInterface
{
    protected $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function get($key, $default = null)
    {
        $content = file_get_contents($this->filename);
        if ($content) {
            $data = json_decode($content, true);
        } else {
            $data = [];
        }

        return $data[$key] ?? null;
    }

    /**
     * @param $key
     * @param $value
     * @return void
     * @deprecated
     * @todo Удалить в версии 2.0
     */
    public function put($key, $value)
    {
        // TODO
    }

    public function set($key, $value, $ttl = null)
    {
        $content = file_get_contents($this->filename);
        if ($content) {
            $data = json_decode($content, true);
        } else {
            $data = [];
        }

        $data[$key] = $value;

        file_put_contents($this->filename, json_encode($data));
    }

    public function delete($key)
    {
        // TODO: Implement delete() method.
    }

    public function clear()
    {
        // TODO: Implement clear() method.
    }

    public function getMultiple($keys, $default = null)
    {
        // TODO: Implement getMultiple() method.
    }

    public function setMultiple($values, $ttl = null)
    {
        // TODO: Implement setMultiple() method.
    }

    public function deleteMultiple($keys)
    {
        // TODO: Implement deleteMultiple() method.
    }

    public function has($key)
    {
        $content = file_get_contents($this->filename);
        if ($content) {
            $data = json_decode($content, true);
        } else {
            $data = [];
        }

        return array_key_exists($key, $data);
    }
}