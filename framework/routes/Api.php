<?php

namespace Framework\Routes;

use FastRoute\RouteCollector;

final class Api extends ARoute implements IRoute
{
    final public static function getRoutes(RouteCollector &$r)
    {
        /*
        // Unused for now
        $r->addGroup('/api', function (RouteCollector &$r) {
            $r->addRoute([self::METHOD_GET], '/whoami', '');
        });
        */
    }
}
