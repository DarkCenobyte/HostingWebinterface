<?php

namespace Framework\Routes;

use FastRoute\RouteCollector;

/**
 * Class Api
 * @package Framework\Routes
 */
final class Api extends ARoute implements IRoute
{
    /**
     * List all the routes for the API, defining the methods allowed, the route, then the path to the function to be called.
     *
     * Routes examples:
     * /index
     * /index/{paramName1}
     * /index/[{optionalParamName1}]
     * ...
     *
     * For more information, @see https://github.com/nikic/FastRoute
     *
     * @param RouteCollector $r
     */
    final public static function getRoutes(RouteCollector &$r)
    {
        $r->addGroup('/api', function (RouteCollector &$r) {
            // INITIAL CODE
            $r->addRoute([self::METHOD_POST], '/initialCode', 'Framework\Controllers\Api\InitialCode@checkInitialCode');

            // SERVER RESOURCES
            $r->addRoute([self::METHOD_GET], '/serverResource', 'Framework\Controllers\Api\ServerResources@getServerResourcesJson');

            // SYSINFO
            $r->addRoute([self::METHOD_GET], '/sysinfo', 'Framework\Controllers\Api\Sysinfo@getSysinfo');

            // MASTERNODE INFO
            $r->addRoute([self::METHOD_GET], '/info', 'Framework\Controllers\Api\MasternodeInfo@getInfo');

            // DAEMON SETTINGS & RESTART
            $r->addRoute([self::METHOD_GET], '/isMasternode', 'Framework\Controllers\Api\DaemonSettings@checkIsMasternode');
            $r->addRoute([self::METHOD_GET], '/isStaking', 'Framework\Controllers\Api\DaemonSettings@checkIsStaking');
            $r->addRoute([self::METHOD_POST], '/setMasternode', 'Framework\Controllers\Api\DaemonSettings@setMasternode');
            $r->addRoute([self::METHOD_POST], '/setStaking', 'Framework\Controllers\Api\DaemonSettings@setStaking');
            $r->addRoute([self::METHOD_GET], '/getPrivKey', 'Framework\Controllers\Api\DaemonSettings@getPrivKey');
            $r->addRoute([self::METHOD_POST], '/setPrivKey', 'Framework\Controllers\Api\DaemonSettings@setPrivKey');
            $r->addRoute([self::METHOD_GET], '/restartDaemon', 'Framework\Controllers\Api\DaemonSettings@restartDaemon');
        });
    }
}
