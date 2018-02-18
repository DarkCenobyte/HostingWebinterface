<?php

namespace Framework\Controllers\Api;

class InitialCode extends AApiController
{
    const INITIAL_FILE = '/var/ALQO/_initial';

    public function checkInitialCode(string $inputCode)
    {
        if (isset($inputCode)) {
            if (file_exists(self::INITIAL_FILE)) {
                $initialCode = file_get_contents(self::INITIAL_FILE);
                $initialCode = str_replace("\n", "", $initialCode);
                $initialCode = str_replace("\r", "", $initialCode);
                if ($initialCode == $inputCode) {
                    die("true");
                }
            }
            die("false");
        }
    }
}
