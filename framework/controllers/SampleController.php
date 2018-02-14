<?php

namespace Framework\Controllers;

class SampleController
{
    public function index(string $msg)
    {
        echo "Hello ${msg}";
    }
}