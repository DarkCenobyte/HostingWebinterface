<?php

namespace Framework\Routes;

use FastRoute\RouteCollector;

final class Web extends ARoute implements IRoute
{
    final public static function getRoutes(RouteCollector &$r)
    {
        $r->addRoute([self::METHOD_GET], '/', 'Framework\Controllers\DashboardController@index');
        $r->addRoute([self::METHOD_GET], '/index', 'Framework\Controllers\DashboardController@index');

        $r->addRoute([self::METHOD_GET], '/register', 'Framework\Controllers\RegisterController@showRegister');
        $r->addRoute([self::METHOD_POST], '/register', 'Framework\Controllers\RegisterController@register');

        $r->addRoute([self::METHOD_GET], '/login', 'Framework\Controllers\RegisterController@showLogin');
        $r->addRoute([self::METHOD_POST], '/login', 'Framework\Controllers\RegisterController@login');
    }
}
