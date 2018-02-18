<?php

namespace Framework\Models;

/**
 * Class UserData
 * @package Framework\Models
 */
class UserData
{
    const PASSWORD_FILE = '/var/ALQO/_webinterface_pw';
    const USER_ID = 'admin';

    private $userData;

    public function __construct()
    {
        $this->userData = [];
        $this->userData['userID'] = self::USER_ID;
        $this->userData['userPass'] = @file_get_contents(self::PASSWORD_FILE);
    }

    public function getUserData() : array
    {
        return $this->userData;
    }

    /**
     * If the _webinterface_pw file doesn't exist, the user has not been registered.
     *
     * @return bool
     */
    public static function isUserExist() : bool
    {
        return file_exists(self::PASSWORD_FILE);
    }

    /**
     * Check if the user is logged in, just looking at the loggedIn value in $_SESSION should be enough for this.
     *
     * @return bool
     */
    public static function isUserLoggedIn() : bool
    {
        return ($_SESSION['loggedIn'] === true);
    }
}
