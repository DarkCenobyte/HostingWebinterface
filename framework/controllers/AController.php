<?php

namespace Framework\Controllers;
use Framework\Handlers\ErrorHandler;

/**
 * Class AController
 * @package Framework\Controllers
 */
class AController
{
    /**
     * Template renderer, usable to render a Twig template
     *
     * @see https://twig.symfony.com/doc/2.x/api.html#rendering-templates
     * @var \Twig_Environment
     */
    protected $renderer;

    /**
     * AController constructor.
     *
     * Initialize Twig environment
     */
    public function __construct()
    {
        // ALQO_FRAMEWORK_BASEPATH = .../HostingWebinterface/public
        $loader = new \Twig_Loader_Filesystem(
            [
                '..' . DIRECTORY_SEPARATOR . 'views',
            ],
            ALQO_FRAMEWORK_BASEPATH
        );

        $this->renderer = new \Twig_Environment(
            $loader,
            [
                'cache' => ALQO_FRAMEWORK_CACHE_PATH
            ]
        );
    }

    /**
     * A default render() function, will try to use the renderer to load a page associate to the controller using
     * the controller class name, suffixed or not by "Controller".
     *
     * Examples:
     * From SampleController class, will try to load /views/sample.html
     * From Sample class, will try to load /views/sample.html
     *
     * @param array $params (associative array)
     */
    protected function render(array $params = [])
    {
        $defaultViewFile = function () {
            return strtolower(
                preg_replace(
                    '/Controller$/',
                    '',
                    get_class($this)
                )) . '.html'
            ;
        };

        try {
            $this->renderer->render($defaultViewFile, $params);
            exit(0);
        } catch (\Twig_Error_Loader $e) {
            ErrorHandler::exceptionCatcher($e);
        } catch (\Twig_Error_Syntax $e) {
            ErrorHandler::exceptionCatcher($e);
        } catch (\Twig_Error_Runtime $e) {
            ErrorHandler::exceptionCatcher($e);
        };
    }
}
