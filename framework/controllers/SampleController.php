<?php

namespace Framework\Controllers;

class SampleController extends AController
{
    public function index(string $msg)
    {
        echo "Hello ${msg}";
    }
}
