<?php

namespace Framework\Controllers;

use Framework\Handlers\RedirectHandler;

class LoginController extends AController
{
    const INITIAL_FILE = '/var/ALQO/_initial';
    const PASSWORD_FILE = '/var/ALQO/_webinterface_pw';
    const USER_ID = 'admin';

    private $userData;

    public function __construct()
    {
        parent::__construct();
        if (! file_exists(self::PASSWORD_FILE)) {
            //RedirectHandler::redirect([RegisterController::class, 'showRegister']);
            RedirectHandler::httpRedirect('/register');
        } else {
            $this->userData['userID'] = self::USER_ID;
            $this->userData['userPass'] = @file_get_contents(self::PASSWORD_FILE);
        }
    }

    public function showLogin()
    {
        if ($_SESSION['loggedIn']) {
            //RedirectHandler::redirect([DashboardController::class, 'index']);
            RedirectHandler::httpRedirect('/');
        } else {
            $this->render();
        }
    }

    public function login(string $userId, string $userPass, array $additional = [])
    {
        if ($userId == $this->userData['userID'] && password_verify($userPass, $this->userData['userPass'])) {
            if (password_needs_rehash($this->userData['userPass'], PASSWORD_DEFAULT)) {
                $this->userData['userPass'] = password_hash($userPass, PASSWORD_DEFAULT);
                file_put_contents(self::PASSWORD_FILE, $this->userData['userPass']);
            }
            echo "authorized";

            $_SESSION['loggedIn'] = true;
            $_SESSION['userId'] = $userId;

            die(0);
        } elseif ($this->upgradeLegacyPasswordHash($userId, $userPass)) {
            echo "authorized";

            $_SESSION['loggedIn'] = true;
            $_SESSION['userId'] = $userId;

            die(0);
        }

        echo "Login failed.";
        $_SESSION['loggedIn'] = false;
        unset($_SESSION['userId']);

        die(1);
    }

    private function isValidMd5(string $md5) : bool
    {
        return (preg_match('/^[a-f0-9]{32}$/', $md5) === 1);
    }

    private function upgradeLegacyPasswordHash(string $userId, string $userPass)
    {
        if ($userId == $this->userData['userID']
            && $this->isValidMd5($this->userData['userPass'])
            && $this->userData['userPass'] === md5($userPass)
        ) {
            $this->userData['userPass'] = password_hash($userPass, PASSWORD_DEFAULT);
            file_put_contents(self::PASSWORD_FILE, $this->userData['userPass']);

            return true;
        }

        return false;
    }

    public function logout()
    {
        $_SESSION['loggedIn'] = false;
        unset($_SESSION['userId']);
        echo "authorized";

        die(0);
    }
}
