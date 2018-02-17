<?php

namespace Framework\Controllers;

class SampleController extends AController
{
    public function index()
    {
        echo "HE";
    }

    public function debug(string $msg = "test")
    {
        echo "Hello ${msg}";
    }

    public function debugTwo(string $msg = "test", string $msg2 = "test2")
    {
        echo "Hello ${msg} ${msg2}";
    }
}
