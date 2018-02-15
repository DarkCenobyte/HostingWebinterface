<?php

namespace Framework\Controllers;

class DashboardController extends AController
{
    public function index(string $msg)
    {
        echo "Hello ${msg}";
    }
}
