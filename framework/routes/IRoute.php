<?php

namespace Framework\Routes;

use FastRoute\RouteCollector;

interface IRoute
{
    public static function getRoutes(RouteCollector &$r);
}
