<?php

namespace Framework\Controllers;

use Framework\Handlers\RedirectHandler;
use Framework\Models\ServerData;
use Framework\Models\UserData;

class DashboardController extends AController
{
    const INITIAL_FILE = '/var/ALQO/_initial';

    private $serverData;
    private $userData;

    public function __construct()
    {
        parent::__construct();
        if (! UserData::isUserExist()) {
            //RedirectHandler::redirect([RegisterController::class, 'showRegister']);
            RedirectHandler::httpRedirect('/register');
        } elseif (! UserData::isUserLoggedIn()) {
            //RedirectHandler::redirect([LoginController::class, 'showLogin']);
            RedirectHandler::httpRedirect('/login');
        } else {
            $this->serverData = (new ServerData())->getServerData();
            $this->userData = (new UserData())->getUserData();
        }
    }

    public function index()
    {
        $this->render([
            'SERVERNAME' => $this->serverData['name'],
            'SERVERHOST' => $this->serverData['host'],
            'IP'         => $this->serverData['ip'],
        ]);
    }
}
