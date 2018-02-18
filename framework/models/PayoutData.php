<?php

namespace Framework\Models;

/**
 * Class PayoutData
 * @package Framework\Models
 */
class PayoutData
{
    const API_WALLET_URL = 'https://hosting.alqo.org/api.php?walletAddr=';

    public function getPayoutData(string $walletAddr) {
        $d = file_get_contents(self::API_WALLET_URL . $walletAddr);

        return json_decode($d, true);
    }
}
