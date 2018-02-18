<?php

namespace Framework\Controllers\Api;

class ServerResources extends AApiController
{
    const SERVER_RESOURCE_FILE = "/var/ALQO/services/data/resources";

    public function getServerResourcesJson()
    {
        echo file_get_contents(self::SERVER_RESOURCE_FILE);
        die(0);
    }
}
