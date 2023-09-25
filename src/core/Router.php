<?php

namespace app\core;
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
        $this->routes['get'][$url] = $handler;
    }

    public function post(string $url, $handler) {
        $this->routes['post'][$url] = $handler;
    }

    public function patch(string $url, $handler) {
        $this->routes['patch'][$url] = $handler;
    }

    public function put(string $url, $handler) {
        $this->routes['put'][$url] = $handler;
    }

    public function delete(string $url, $handler) {
        $this->routes['delete'][$url] = $handler;
    }

    public function findHandler()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        if (isset($this->routes[$method][$path])) {
            return $this->routes[$method][$path];
        }

        foreach ($this->routes[$method] as $route => $handler) {
            $pattern = preg_replace('/(:\w+)/', '(\w+)', $route);
            $pattern = "@^" . $pattern . "$@";

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);
                $this->request->setParams($matches);
                return $handler;
            }
        }
        return null;
    }

    public function resolve()
    {
        $handler = $this->findHandler();
        if (!$handler) {
            $this->response->setStatusCode(404);
            return "Route not found.";
        }
        if (is_array($handler)) {
            $controller = new $handler[0];
//            $middlewares = $controller->getMiddlewares();
//            foreach ($middlewares as $middleware) {
//                $middleware->execute();
//            }
            $handler[0] = $controller;
        }
        return call_user_func($handler, $this->request);
    }
}