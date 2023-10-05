<?php

namespace app\core;
use app\exceptions\NotFoundException;

class Router
{
    private array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }
    public function get(string $url, $handler) {
        $this->routes[$url]['get'] = $handler;
    }

    public function post(string $url, $handler) {
        $this->routes[$url]['post'] = $handler;
    }

    public function patch(string $url, $handler) {
        $this->routes[$url]['patch'] = $handler;
    }

    public function put(string $url, $handler) {
        $this->routes[$url]['put'] = $handler;
    }

    public function delete(string $url, $handler) {
        $this->routes[$url]['delete'] = $handler;
    }

    /**
     * @throws NotFoundException
     */
    public function findHandler()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        if (isset($this->routes[$path][$method])) {
            return $this->routes[$path][$method];
        }
        foreach (array_keys($this->routes) as $route) {
            $pattern = preg_replace('/(:\w+)/', '(\w+)', $route);
            $pattern = "@^" . $pattern . "$@";
            if (preg_match($pattern, $path, $matches)) {
                if (isset($this->routes[$route][$method])) {
                    array_shift($matches);
                    $this->request->setParams($matches);
                    return $this->routes[$route][$method];
                }
                throw new NotFoundException(true);
            }
        }
        throw new NotFoundException(true);
    }

    /**
     * @throws NotFoundException
     */
    public function resolve()
    {
        $handler = $this->findHandler();
        if (is_array($handler)) {
            $controller = new $handler[0];
            $method = $handler[1];
            $middlewares = $controller->getMiddlewares();
            if (isset($middlewares[$method])) {
                $middleware = new $middlewares[$method];
                $middleware->execute(true);
            }
            $handler[0] = $controller;
        }
        return call_user_func($handler, $this->request);
    }
}