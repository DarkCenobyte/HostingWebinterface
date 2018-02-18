<?php

namespace Framework\Models;

/**
 * Class ServerData
 * @package Framework\Models
 */
class ServerData
{
    const SERVERINFO_FILE = '/var/ALQO/_serverinfo';

    private $serverData;

    public function __construct()
    {
        $this->serverData = json_decode(file_get_contents(self::SERVERINFO_FILE), true);
    }

    public function getServerData() : array
    {
        return $this->serverData;
    }
}
