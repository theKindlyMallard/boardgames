<?php
/**
 * Main application class.
 * 
 * @author theKindlyMallard <the.kindly.mallard@gmail.com>
 */
class Application {

    /**
     * @var string The method in controller often named as action.
     */
    private $action = null;

    /**
     * @var string The controller name.
     */
    private $controller = null;

    /**
     * @var array Contains parameters from URL.
     */
    private $parameters = [];

    /**
     * Analyze the URL elements and calls the according controller/method or the fallback.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    public function __construct() {
        //Get data from url.
        $this->splitUrl();
        $controllerName = ucfirst($this->controller) . Controller\Controller::SUFFIX_FOR_CONTROLLERS;
        //Check if such controller exist.
        if (file_exists(DIR_CONTROLLER . $controllerName . FILE_PHP)) {
            //Load this file.
            require_once DIR_CONTROLLER . $controllerName . FILE_PHP;
            //Controller name with namespace.
            $fullControllerName = Controller\Controller::SUFFIX_FOR_CONTROLLERS . DS . $controllerName;
            //Create this controller object.
            $this->controller = new $fullControllerName();
            //Create method name from recived action.
            $actionMethod = Controller\Controller::PREFIX_FOR_ACTIONS . $this->action;
            //Check for method: does such a method exist in the controller?
            if (method_exists($this->controller, $actionMethod)) {
                //Call the method and pass the arguments to it.
                $this->controller->{$actionMethod}($this->parameters);
            } else {
                //Default fallback: call the index() method of a selected controller.
                $this->controller->action_index();
            }
        } else {
            //Invalid URL, so simply show home/index.
            (new \Controller\HomeController())->action_index();
        }
    }

    /**
     * Gets URL from $_GET and split it to the parts.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    private function splitUrl() {
        
        $url = filter_input(INPUT_GET, 'url');

        if (isset($url)) {
            //Split URL.
            $url = rtrim($url, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            //Put URL parts into according properties.
            $this->controller = isset($url[0]) ? strtolower($url[0]) : null;
            $this->action = isset($url[1]) ? strtolower($url[1]) : null;
            //Clear previous parameters.
            $this->parameters = [];
            $urlCount = count($url);
            //Check if sent parameters for action.
            if ($urlCount > 1) {
                for ($i = 2; $i < $urlCount; $i++) {
                    $this->parameters[] = $url[$i];
                }
            }
        }
    }
}
