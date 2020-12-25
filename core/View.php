<?php

namespace Core;

/**
 * Class View
 * @package Core
 */
class View
{
    private string $basePath;
    private array $parameters;

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->basePath = __DIR__ . '/../resources/views';
    }

    /**
     * @param $template
     * @param $parameters
     * @return string
     */
    public function render($template, $parameters = [])
    {
        ob_start();

        $this->parameters = $parameters;
        $template = str_replace('.', '/', $template);
        include "{$this->basePath}/layouts/header.php";
        include "{$this->basePath}/$template.php";
        include "{$this->basePath}/layouts/footer.php";

        return ob_get_clean();
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function __get($key)
    {
        return (isset($this->parameters[$key]) ? $this->parameters[$key] : null);
    }

    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->parameters[$key]);
    }

    /**
     * @param $key
     */
    public function __unset($key)
    {
        unset($this->parameters[$key]);
    }
}