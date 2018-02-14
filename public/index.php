<?php
session_start();
require '../vendor/autoload.php';

/**
 * Route Loading
 */

// @TODO: use cachedDispatcher instead
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r){
    \Framework\Routes\Web::getRoutes($r);
    \Framework\Routes\Api::getRoutes($r);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];

function parseQuery(&$vars): string
{
    if ($c = $_GET['c']) {
        return $c;
    } else {
        return parseBeautifulQuery();
    }
}

function parseBeautifulQuery(): string
{
    $uri = $_SERVER['REQUEST_URI'];

    if (false !== $pos = strpos($uri, '?')) {
        $uri = substr($uri, 0, $pos);
    }

    return rawurldecode($uri);
}

$routeInfo = $dispatcher->dispatch($httpMethod, parseQuery($vars));
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "404";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "405";
        break;
    case FastRoute\Dispatcher::FOUND:
        list($class, $method) = explode('@', $routeInfo[1], 2);
        call_user_func_array([new $class, $method], $routeInfo[2]);
        break;
}
