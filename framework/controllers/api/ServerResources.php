<?php

namespace Framework\Controllers\Api;

class ServerResources
{
    public function __construct()
    {
        //
    }

    public function generateJson(array $arr)
    {
        echo json_encode($arr);
        die();
    }
}
