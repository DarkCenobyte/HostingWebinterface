<?php

namespace Framework\Controllers\Api;

use Framework\Controllers\Api\Traits\GenerateJsonTrait;
use Framework\Models\DaemonData;
use Framework\Models\PayoutData;

class MasternodeInfo extends AApiController
{
    use GenerateJsonTrait;

    const API_BALANCE_URL = 'http://explorer.alqo.org/ext/getbalance/';

    private function openableSocket() : bool
    {
        return @fsockopen(
            "127.0.0.1",
            55000,
            $errno,
            $errstr,
            1
        ) === false ?: true;
    }

    public function getInfo()
    {
        $arr = [];
        $daemonData = new DaemonData();
        $info = $daemonData->readInfo();
        $peerInfo = $daemonData->readPeerInfo();
        $masternodeListFull = $daemonData->readMasterNodeListFull();
        $masternodeListRank = $daemonData->readMasterNodeListRank();
        $masternodeStatus = $daemonData->readMasterNodeStatus();

        $arr['status'] = $this->openableSocket();
        $arr['block'] = $info['blocks'];
        $arr['difficulty'] = $info['difficulty'];
        $arr['walletVersion'] = $info['walletversion'];
        $arr['protocolVersion'] = $info['protocolversion'];
        $arr['connections'] = $info['connections'];

        $mnStatus = false;

        if ($masternodeStatus['status'] == "Masternode successfully started") {
            $mnStatus = true;
        }
        $arr['masternodeStatus'] = $mnStatus;

        $arr['masternodeIp'] = null;
        $arr['masternodePayoutWallet'] = null;
        $arr['masternodeWalletBalance'] = null;

        if ($mnStatus) {
            $arr['masternodeIp'] = $masternodeStatus['service'];
            $arr['masternodePayoutWallet'] = $masternodeStatus['pubkey'];
            $arr['masternodeWalletBalance'] = file_get_contents(self::API_BALANCE_URL . $arr['masternodePayoutWallet']);
        }
        $arr['masternodePayoutData'] = isset($arr['masternodePayoutWallet']) ?
            (new PayoutData())->getPayoutData($arr['masternodePayoutWallet'])
            : ''
        ;

        $this->generateJson($arr);
    }
}
