<?php

namespace Framework\Handlers;

/**
 * Class ErrorHandler
 *
 * Handle the errors and exceptions to keep it clean in production environment by using custom error templates pages.
 *
 * @package Framework\Handlers
 */
class ErrorHandler
{
    /**
     * Constant 404 HTTP CODE (Page not found)
     */
    const PAGE_NOT_FOUND = 404;
    /**
     * Constant 405 HTTP CODE (Method not allowed)
     */
    const METHOD_NOT_ALLOWED = 405;
    /**
     * Constant 500 HTTP CODE (Internal error)
     */
    const INTERNAL_ERROR = 500;

    /**
     * ErrorHandler constructor.
     */
    public function __construct()
    {
        if (! ALQO_FRAMEWORK_DEBUG) {
            set_error_handler('errorHandler');
            set_exception_handler('exceptionHandler');
        } else {
            restore_error_handler();
            restore_exception_handler();
        }
    }

    /**
     * errorHandler function, used by set_error_handler()
     *
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     */
    public function errorHandler(int $errno, string $errstr, string $errfile, int $errline)
    {
        $this->redirectErrorPages(self::INTERNAL_ERROR);
        die(2);
    }

    /**
     * Static exceptionCatcher, to make easy use of it from anywhere, if you specify a statusCode,
     * be sure to had a correspondent error template make for this code.
     *
     * @param \Throwable $ex
     * @param int $statusCode
     */
    public static function exceptionCatcher(\Throwable $ex, int $statusCode = 500)
    {
        if (ALQO_FRAMEWORK_DEBUG) {
            self::displayDebug($ex);
        }
        self::redirectErrorPages($statusCode);
        die(1);
    }

    /**
     * exceptionHandler function, used by set_exception_handler()
     *
     * @param \Throwable $ex
     */
    public function exceptionHandler(\Throwable $ex)
    {
        $this->redirectErrorPages(self::INTERNAL_ERROR);
        die(1);
    }

    /**
     * Handle bad queries from the router behaviors (404 / 405 errors)
     *
     * @param int $statusCode
     */
    public function handleQueryError(int $statusCode)
    {
        $this->redirectErrorPages($statusCode);
    }

    private static function displayDebug(\Throwable $ex)
    {
        $loader = new \Twig_Loader_Filesystem(
            [
                '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'errors',
            ],
            ALQO_FRAMEWORK_BASEPATH
        );
        $renderer = new \Twig_Environment(
            $loader,
            [
                'cache' => ALQO_FRAMEWORK_CACHE_PATH ? ALQO_FRAMEWORK_CACHE_PATH . DIRECTORY_SEPARATOR . 'errors' : false,
            ]
        );

        try {
            $renderer->render('debug.html', [
                'error_code' => $ex->getCode(),
                'error_msg'  => $ex->getMessage(),
                'trace'      => $ex->getTraceAsString(),
            ]);
            die(1);
        } catch (\Twig_Error $e) {
            $errCode = $e->getCode();
            echo "Fatal unhandled error. Status code: ${$errCode}.<br />";
            if (ALQO_FRAMEWORK_DEBUG) {
                echo "Debug mode:<br />";
                var_dump($e->getMessage());
                var_dump($e->getTrace());
            }

            die(3);
        }
    }

    /**
     * Redirect errors to correspondant template in the views/errors folder.
     * Template should be named "${statusCode}.html" (eg. 404.html, 500.html, ...)
     *
     * @param int $statusCode
     */
    private static function redirectErrorPages(int $statusCode)
    {
        $loader = new \Twig_Loader_Filesystem(
            [
                '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'errors',
            ],
            ALQO_FRAMEWORK_BASEPATH
        );
        $renderer = new \Twig_Environment(
            $loader,
            [
                'cache' => ALQO_FRAMEWORK_CACHE_PATH ? ALQO_FRAMEWORK_CACHE_PATH . DIRECTORY_SEPARATOR . 'errors' : false,
            ]
        );

        try {
            $renderer->render("${statusCode}.html");
            die(1);
        } catch (\Twig_Error $e) {
            echo "Fatal unhandled error. Status code: ${statusCode}.<br />";
            if (ALQO_FRAMEWORK_DEBUG) {
                echo "Debug mode:<br />";
                var_dump($e->getMessage());
                var_dump($e->getTrace());
            }

            die(3);
        }
    }
}
