<?php

namespace Controller;

/**
 * Home controller.
 * 
 * @author theKindlyMallard <the.kindly.mallard@gmail.com>
 */
class HomeController extends Controller {
    
    /**
     * @var \Model\HomeModel Default model for this controller. 
     */
    protected $model;
    
    /**
     * Default action for controller.
     * 
     * @param array $parameters
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    public function action_index(array $parameters = []) {
        $this->outputHeader();
        echo 'HOME';
        $this->outputFooter();
    }
}