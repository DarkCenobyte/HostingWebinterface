<?php

namespace Framework\Controllers\Api;

use Framework\Controllers\Api\Traits\GenerateJsonTrait;

class Sysinfo extends AApiController
{
    use GenerateJsonTrait;

    public function getSysinfo()
    {
        if (! $this->isReadable()) {
            return null;
        }

        $os = shell_exec('cat /etc/os-release');
        preg_match_all('/.*=/', $os, $matchListIds);
        $listIds = $matchListIds[0];

        preg_match_all('/=.*/', $os, $matchListVal);
        $listVal = $matchListVal[0];

        array_walk($listIds, function (&$v, $k) {
            $v = strtolower(str_replace('=', '', $v));
        });

        array_walk($listVal, function (&$v, $k) {
            $v = preg_replace('/=|"/', '', $v);
        });

        $arr = array_combine($listIds, $listVal);
        $arr['TotalRAM'] = $this->getRamTotal();

        $this->generateJson($arr);
    }

    private function getRamTotal() : string
    {
        $exec_free = explode("\n", trim(shell_exec('free')));
        $get_mem = preg_split("/[\s]+/", $exec_free[1]);
        $mem = number_format(round($get_mem[1]/1024, 2), 2);

        return $mem;
    }

    private function isReadable() : bool
    {
        if (false == function_exists("shell_exec")
            || false == is_readable("/etc/os-release")) {
            return false;
        }

        return true;
    }
}
