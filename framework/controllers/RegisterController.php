<?php

namespace Framework\Controllers;

use Framework\Handlers\ErrorHandler;

class RegisterController extends AController
{
    const INITIAL_FILE = '/var/ALQO/_initial';
    const PASSWORD_FILE = '/var/ALQO/_webinterface_pw';
    const USER_ID = 'admin';

    private $userData;

    public function __construct()
    {
        parent::__construct();
        if ($this->isAlreadyRegistered()) {
            ErrorHandler::exceptionCatcher(new \HttpException('Forbidden Access, already registered.', 403), 403);
        }
        $this->userData['userID'] = self::USER_ID;
    }

    private function isAlreadyRegistered() : bool
    {
        return file_exists(self::PASSWORD_FILE);
    }

    public function showRegister()
    {
        $this->render();
    }

    public function register($inputInitialCode)
    {
        $realInitialCode = file_get_contents(self::INITIAL_FILE);
        $realInitialCode = str_replace(["\n", "\r"], "", $realInitialCode);
        if ($inputInitialCode == $realInitialCode) {
            $this->userData['userPass'] = password_hash($_POST['userPass'], PASSWORD_DEFAULT);
            file_put_contents(self::PASSWORD_FILE, $this->userData['userPass']);
            $_SESSION['loggedIn'] = false;
            echo "authorized";

            die(0);
        } else {
            echo "unauthorized";

            die(1);
        }
    }
}
