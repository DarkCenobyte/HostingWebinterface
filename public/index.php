<?php
session_start();
require '../vendor/autoload.php';

/**
 * Global Constants
 */

define('ALQO_FRAMEWORK_BASEPATH', __DIR__, false);

define('ALQO_FRAMEWORK_DEBUG', false, false);

define('ALQO_FRAMEWORK_CACHE_PATH', false, false); // '..' . DIRECTORY_SEPARATOR . 'cache' (relative to ALQO_FRAMEWORK_BASEPATH) ; false to disable cache

/**
 * Error Handler Initialization
 */

$errorHandler = new \Framework\Handlers\ErrorHandler();

/**
 * Route Loading
 */

// @TODO: use cachedDispatcher instead
$dispatcher = FastRoute\simpleDispatcher(
    function (FastRoute\RouteCollector $r) {
        \Framework\Routes\Web::getRoutes($r);
        \Framework\Routes\Api::getRoutes($r);
    })
;

$httpMethod = $_SERVER['REQUEST_METHOD'];

/**
 * Parse the user query, if ?c= is present in the URL, for urls like domain.abc/?c=/route/{params}/...
 * else expect to be used with a beautifying apache rewriting
 *
 * @return string
 */
function parseQuery(): string
{
    if ($c = $_GET['c']) {
        return $c;
    } else {
        return parseBeautifulQuery();
    }
}

/**
 * Parse Apache rewrited URL, like domain.abc/route/{params}/...
 *
 * @return string
 */
function parseBeautifulQuery(): string
{
    $uri = $_SERVER['REQUEST_URI'];

    if (false !== $pos = strpos($uri, '?')) {
        $uri = substr($uri, 0, $pos);
    }

    return rawurldecode($uri);
}

/**
 * Dispatch the user to a parsed route, or call the errorHandler
 */

$routeInfo = $dispatcher->dispatch($httpMethod, parseQuery());
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        $errorHandler->handleQueryError(404);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        $errorHandler->handleQueryError(405);
        break;
    case FastRoute\Dispatcher::FOUND:
        list($class, $method) = explode('@', $routeInfo[1], 2);
        call_user_func_array([new $class, $method], $routeInfo[2]);
        break;
}
