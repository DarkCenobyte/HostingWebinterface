<?php

namespace Framework\Controllers\Api;

class DaemonSettings extends AApiController
{
    const DAEMON_CONFIG_FILE = '/var/ALQO/data/alqo.conf';

    private function getLine(string $c) : string
    {
        shell_exec('sudo chmod -f 777 ' . self::DAEMON_CONFIG_FILE);
        $handle = fopen(self::DAEMON_CONFIG_FILE, "r");
        $v = "";
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (strpos($line, $c."=") !== false) {
                    $v = explode("=", $line)[1];
                    break;
                }
            }
        }
        $return = str_replace("\n", "", $v);
        $return = str_replace("\r", "", $return);
        $return = str_replace(" ", "", $return);

        return $return;
    }

    private function setLine(string $c, string $v, string $nv)
    {
        shell_exec('sudo chmod -f 777 ' . self::DAEMON_CONFIG_FILE);
        $d = file_get_contents(self::DAEMON_CONFIG_FILE);
        $d = str_replace($c."=".$v, $c."=".$nv, $d);
        file_put_contents(self::DAEMON_CONFIG_FILE, $d);
    }

    public function restartDaemon()
    {
        print_r(exec('/var/ALQO/alqo-cli -datadir=/var/ALQO/data stop'));
        sleep(10);
        print_r(exec('sudo /var/ALQO/alqod -datadir=/var/ALQO/data | exit'));
        die(0);
    }

    public function checkIsMasternode()
    {
        echo $this->getLine("masternode");
    }

    public function checkIsStaking()
    {
        echo $this->getLine("staking");
    }

    public function setMasternode(string $setMasternode)
    {
        $v = $this->getLine("masternode");
        $this->setLine("masternode", $v, $setMasternode);
        echo $setMasternode;
    }

    public function setStaking(string $setStaking)
    {
        $v = $this->getLine("staking");
        $this->setLine("staking", $v, $setStaking);
        echo $setStaking;
    }

    public function getPrivKey()
    {
        echo $this->getLine("masternodeprivkey");
    }

    public function setPrivKey(string $setPrivKey)
    {
        $v = $this->getLine("masternodeprivkey");
        $this->setLine("masternodeprivkey", $v, $setPrivKey);
        echo $v;
    }
}
