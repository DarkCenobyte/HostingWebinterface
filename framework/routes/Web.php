<?php

namespace Framework\Routes;

use FastRoute\RouteCollector;

final class Web extends ARoute implements IRoute
{
    final public static function getRoutes(RouteCollector &$r)
    {
        $r->addRoute([self::METHOD_GET], '/', 'Framework\Controllers\SampleController@index');
        $r->addRoute([self::METHOD_GET], '/index/[{msg}]', 'Framework\Controllers\SampleController@debug');
        $r->addRoute([self::METHOD_GET], '/index/{msg}/ba/{msg2}', 'Framework\Controllers\SampleController@debugTwo');
        $r->addRoute([self::METHOD_GET], '/hello/{msg}', '');
    }
}
