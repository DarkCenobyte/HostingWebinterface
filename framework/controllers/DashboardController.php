<?php

namespace Framework\Controllers;

use Framework\Handlers\RedirectHandler;

class DashboardController extends AController
{
    const INITIAL_FILE = '/var/ALQO/_initial';
    const PASSWORD_FILE = '/var/ALQO/_webinterface_pw';
    const SERVERINFO_FILE = '/var/ALQO/_serverinfo';
    const USER_ID = 'admin';

    private $serverData;
    private $userData;

    public function __construct()
    {
        parent::__construct();
        if (! file_exists(self::PASSWORD_FILE)) {
            //RedirectHandler::redirect([RegisterController::class, 'showRegister']);
            RedirectHandler::httpRedirect('/register');
        } elseif(! $_SESSION['loggedIn']) {
            //RedirectHandler::redirect([LoginController::class, 'showLogin']);
            RedirectHandler::httpRedirect('/login');
        } else {
            $this->serverData = json_decode(file_get_contents(self::SERVERINFO_FILE), true);
            $this->userData['userID'] = self::USER_ID;
            $this->userData['userPass'] = @file_get_contents(self::PASSWORD_FILE);
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
