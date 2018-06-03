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
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    public function __construct(bool $loadModel = true) {
        parent::__construct($loadModel);
        
        session_id(UserController::SESSION_ID_USER_SIGN_IN);
        session_start();
    }
    
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