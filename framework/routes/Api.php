<?php

namespace Framework\Routes;

use FastRoute\RouteCollector;

final class Api extends ARoute implements IRoute
{
    final public static function getRoutes(RouteCollector &$r)
    {
        $r->addGroup('/api', function (RouteCollector &$r) {
            // GENERATE JSON (javascript should handle this instead)
            // $r->addRoute([self::METHOD_POST], '/generateJson', 'Framework\Controllers\Api\GenerateJson@generateJson');

            // SERVERRESOURCES
            $r->addRoute([self::METHOD_GET], '/serverResource', '');

            // RAM TOTAL
            $r->addRoute([self::METHOD_GET], '/ramTotal', '');

            // SYSINFO
            $r->addRoute([self::METHOD_GET], '/sysinfo', '');

            // DAEMON DATA
            $r->addRoute([self::METHOD_GET], '/readInfo', '');
            $r->addRoute([self::METHOD_GET], '/readPeerInfo', '');
            $r->addRoute([self::METHOD_GET], '/readMasterNodeListFull', '');
            $r->addRoute([self::METHOD_GET], '/readMasterNodeListRank', '');
            $r->addRoute([self::METHOD_GET], '/readMasterNodeStatus', '');

            // PAYOUT DATA
            $r->addRoute([self::METHOD_GET], '/getPayoutData', '');

            // MASTERNODE INFO
            $r->addRoute([self::METHOD_GET], '/info', '');

            // DAEMON SETTINGS & RESTART
            $r->addRoute([self::METHOD_GET], '/getLine', '');
            $r->addRoute([self::METHOD_GET], '/setLine', '');
            $r->addRoute([self::METHOD_GET], '/restartDaemon', '');
            $r->addRoute([self::METHOD_GET], '/checkIsMasternode', '');
            $r->addRoute([self::METHOD_GET], '/checkIsStaking', '');
            $r->addRoute([self::METHOD_GET], '/setMasternode', '');
            $r->addRoute([self::METHOD_GET], '/setStaking', '');
            $r->addRoute([self::METHOD_GET], '/getPrivKey', '');
            $r->addRoute([self::METHOD_GET], '/setPrivKey', '');
        });
    }
}
