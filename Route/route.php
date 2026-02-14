<?php


class Route
{
    public static $routes =  [];
public static function get($URL, $callback)
{
    self::$routes['GET'][] = [$URL, $callback];
}

public static function post($URL, $callback)
{
    self::$routes['POST'][] = [$URL, $callback];
}
public static function dispatch()
{
    $method = $_SERVER['REQUEST_METHOD'];

    $URL = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $URL = str_replace('/Madad', '', $URL);
    $URL = rtrim($URL, '/');

    if ($URL === '') {
        $URL = '/';
    }

    if (!isset(self::$routes[$method])) {
        require_once('src/app/view/404.php');
        return;
    }

    foreach (self::$routes[$method] as [$route, $callback]) {

        $pattern = "#^" . $route . "$#";

        if (preg_match($pattern, $URL, $matches)) {
            array_shift($matches); // remove full match
            return $callback(...$matches);
        }
    }

    require_once('src/app/view/404.php');
}

}