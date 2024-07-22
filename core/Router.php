<?php

namespace PHPFramework;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];
    public array $route_params = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function add($uri, $callback, $method): self
    {
        $uri = trim($uri, '/');
        if (is_array($method)) {
            $method = array_map('strtoupper', $method);
        } else {
            $method = [strtoupper($method)];
        }

        $this->routes[] = [
            'path' => "/{$uri}",
            'callback' => $callback,
            'middleware' => null,
            'method' => $method,
        ];

        /* foreach($method as $item_method) {
            $this->routes[$item_method]["/{$uri}"] = [
                'callback' => $callback,
                'middleware' => null,
            ];
        } */
        return $this;
    }

    public function get($uri, $callback): self
    {
        return $this->add($uri, $callback, 'get');
        /* $uri = trim($uri, '/');
        $this->routes['GET']["/{$uri}"] = $callback; */
    }

    public function post($uri, $callback): self
    {
        return $this->add($uri, $callback, 'post');
        /* $uri = trim($uri, '/');
        $this->routes['POST']["/{$uri}"] = $callback; */
    }

    public function dispatch(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->matchRoute($method, $path);
        
        if (false === $callback) {
            abort();
        }
        if (is_array($callback['callback'])) {
            $callback['callback'][0] = new $callback['callback'][0];
            app()->layout = $callback['callback'][0]->layout ?? LAYOUT;
        }
        return call_user_func($callback['callback']);
    }

    public function matchRoute($method, $path)
    {
        foreach ($this->routes as $route) {
            if (preg_match("#^{$route['path']}$#", "/{$path}", $matches) && in_array($this->request->getMethod(), $route['method'])) {

                if ($route['middleware']) {
                    $middleware = MIDDLEWARE[$route['middleware']] ?? false;
                    if ($middleware) {
                        (new $middleware)->handle();
                    }
                }

                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $this->route_params[$key] = $value;
                    }
                }
                return $route;
            }
        }
        return false;
    }

    public function only($middleware): self
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $middleware;
        return $this;
    }
}