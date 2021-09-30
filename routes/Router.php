<?php

namespace Router;

use App\Exceptions\NotFoundException;

class Router {
    
    private $url;
    private $routes = [];

    public function __construct($url) {
        $this->url = trim($url, '/');
    }

    public function get(string $path, string $action) {
        $this->routes['GET'][] = new Route($path, $action);
    }

    public function post(string $path, string $action) {
        $this->routes['POST'][] = new Route($path, $action);
    }

    public function run() {
        // Permet de rester la même méthode si c'est du GET ou du POST
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if($route->matches($this->url)) {
               return $route->execute();
            }
        }

        throw new NotFoundException("Page introuvable", 404);
    }
}