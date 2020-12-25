<?php

namespace Core;

/**
 * Class Request
 * @package Core
 */
class Request
{
    /**
     * @var array|string
     */
    private $storage;

    /**
     * @var void
     */
    private $path;

    /**
     * @var mixed
     */
    private $method;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->storage = $this->cleanInput($_REQUEST);
        $this->path = $this->parseUrl($_SERVER['REQUEST_URI']);
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @param $data
     * @return array|string
     */
    private function cleanInput($data)
    {
        if (is_array($data)) {
            $cleaned = [];
            foreach ($data as $key => $value) {
                $cleaned[$key] = $this->cleanInput($value);
            }
            return $cleaned;
        }
        return stripslashes(trim(htmlspecialchars($data, ENT_QUOTES)));
    }

    /**
     * @param $url
     * @return mixed|string
     */
    private function parseUrl($url)
    {
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);
        return $parsed_url['path'] ?? '/';
    }

    /**
     * @return array|string
     */
    public function all()
    {
        return $this->storage;
    }

    /**
     * @return array|string
     */
    public function validated()
    {
        return array_filter($this->storage, function ($value) {
            if (is_array($value)) {
                $value = array_filter($value, function ($v) {
                    return $v !== '';
                });

            }

            return is_string($value) && $value !== '' || !empty($value);
        });
    }

    /**
     * @param $name
     * @return mixed|string
     */
    public function __get($name)
    {
        if (isset($this->storage[$name])) {
            return $this->storage[$name];
        }
    }

    /**
     * @return mixed|string|void
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }
}