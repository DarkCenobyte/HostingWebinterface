<?php

namespace Framework\Models;

/**
 * Class DaemonData
 * @package Framework\Models
 */
class DaemonData
{
    const GET_INFO_PATH = '/var/ALQO/services/data/getinfo';
    const GET_PEER_INFO_PATH = '/var/ALQO/services/data/getpeerinfo';
    const MASTERNODE_LIST_FULL_PATH = '/var/ALQO/services/data/masternode_list_full';
    const MASTERNODE_LIST_RANK_PATH = '/var/ALQO/services/data/masternode_list_rank';
    const MASTERNODE_STATUS = '/var/ALQO/services/data/masternode_status';

    public function readInfo()
    {
        $d = file_get_contents(self::GET_INFO_PATH);

        return json_decode($d, true);
    }

    public function readPeerInfo()
    {
        $d = file_get_contents(self::GET_PEER_INFO_PATH);

        return json_decode($d, true);
    }

    public function readMasterNodeListFull()
    {
        $d = file_get_contents(self::MASTERNODE_LIST_FULL_PATH);

        return json_decode($d, true);
    }

    public function readMasterNodeListRank()
    {
        $d = file_get_contents(self::MASTERNODE_LIST_RANK_PATH);

        return json_decode($d, true);
    }

    public function readMasterNodeStatus()
    {
        $d = file_get_contents(self::MASTERNODE_STATUS);

        return json_decode($d, true);
    }
}
