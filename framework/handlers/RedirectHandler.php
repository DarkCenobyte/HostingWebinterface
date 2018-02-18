<?php

namespace Framework\Handlers;

/**
 * Class RedirectHandler
 * Handle redirection between controllers class and methods
 *
 * @package Framework\Handlers
 */
class RedirectHandler
{
    /**
     * Redirect to another controller and method
     *
     * @param array $controllerMethod should look like this: [MyCustomClass::class, 'methodName']
     * @param array $params
     * @return mixed
     */
    public static function redirect(array $controllerMethod, array $params = [])
    {
        if (count($controllerMethod) === 2 && class_exists($controllerMethod[0])) {
            $redirect = new $controllerMethod[0]();
            if (method_exists($redirect, $controllerMethod[1])) {
                $redirect->{$controllerMethod[1]}(...$params);
            } else {
                ErrorHandler::exceptionCatcher(new \Exception('Redirect to a non-existent method.'));
            }
        } else {
            ErrorHandler::exceptionCatcher(new \Exception('Invalid input or non-existent class.'));
        }
        die(0);
    }

    /**
     * Redirect the client browser to another URL
     *
     * @param string $url
     * @param bool $isAbsolute
     */
    public static function httpRedirect(string $url, bool $isAbsolute = false)
    {
        if ($isAbsolute) {
            header("Location: ${url}");
        } else {
            header("Location: ${$_SERVER['HTTP_HOST']}${url}");
        }
        die(0);
    }
}
