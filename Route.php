<?php
class Router {
    private array $getRoutes = [];
    private array $postRoutes = [];

    // تسجيل مسار GET
    public function get(string $path, callable $callback): void {
        $this->getRoutes[$path] = $callback;
    }

    // تسجيل مسار POST
    public function post(string $path, callable $callback): void {
        $this->postRoutes[$path] = $callback;
    }

    // تنفيذ التوجيه
    public function dispatch(): void {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET' && isset($this->getRoutes[$url])) {
            call_user_func($this->getRoutes[$url]);
        } elseif ($method === 'POST' && isset($this->postRoutes[$url])) {
            call_user_func($this->postRoutes[$url]);
        } else {
            // صفحة 404
            require 'view/404.php';
        }
    }
}
