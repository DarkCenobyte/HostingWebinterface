<?php

namespace Framework\Controllers\Api;

use Framework\Handlers\ErrorHandler;
use Framework\Models\UserData;

/**
 * Class AApiController
 * @package Framework\Controllers\Api
 */
class AApiController
{
    /**
     * AApiController constructor.
     *
     * Check the user is connected, so nobody unauthenticated could use the AJAX/Api calls
     */
    public function __construct()
    {
        if (! UserData::isUserLoggedIn()) {
            ErrorHandler::exceptionCatcher(new \Exception('Permission denied.', 403), 403);
        }
    }
}
