<?php

namespace Core;

use Exception;

/**
 * Class App
 */
final class App
{
    private static $instance;

    /**
     * @var DB
     */
    public DB $db;

    /**
     * App constructor.
     */
    private function __construct()
    {
    }

    /**
     * Create singleton object
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @param $authUser
     * @param $authPassword
     */
    function basicAuth($authUser, $authPassword) {
        $AUTH_USER = $authUser;
        $AUTH_PASS = $authPassword;
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
        $is_not_authenticated = (
            !$has_supplied_credentials ||
            $_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
            $_SERVER['PHP_AUTH_PW']   != $AUTH_PASS
        );

        if ($is_not_authenticated) {
            header('HTTP/1.1 401 Authorization Required');
            header('WWW-Authenticate: Basic realm="Access denied"');
            exit;
        }
    }

    /**
     * Method for star server
     *
     * @param  array  $config
     * @param  Router  $router
     * @return mixed
     * @throws Exception
     */
    public function handle(array $config, Router $router)
    {
        try {
            $this->db = DB::connection(
                $config['driver'],
                $config['port'],
                $config['host'],
                $config['database'],
                $config['username'],
                $config['password']
            );

            $request = new Request();
            if($request->getPath() === '/admin'){
                $this->basicAuth($config['auth_user'], $config['auth_password']);
            }
            $result = $router->mapRequest($request);
            $controller = "Src\\Controllers\\$result[controller]";
            $action = $result['action'];

            if (isset($result['params'])) {
                return (new $controller)->$action($request, $result['params']);
            }

            return (new $controller)->$action($request);
        } catch (Exception $exception) {
            echo json_encode(['Error' => $exception->getMessage()]);
        }
    }
}