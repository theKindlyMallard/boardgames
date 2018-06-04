<?php

namespace Controller;

/**
 * User controller.
 * 
 * @author theKindlyMallard <the.kindly.mallard@gmail.com>
 */
class UserController extends Controller {
    
    /**
     * @var string Name of form field login.
     */
    const FIELD_LOGIN = 'userLogin';
    /**
     * @var string Name of form field login.
     */
    const FIELD_PASSWORD = 'userPassword';
    
    /**
     * @var string Name of sign in form.
     */
    const FORM_NAME_SIGN_IN = 'userSignIn';
    
    /**
     * @var string Session ID when user signed in.
     */
    const SESSION_ID_USER_SIGN_IN = 'userSignIn';
    /**
     * @var string Key for session variable contains signed in user data.
     */
    const SESSION_KEY_USER_DATA = 'signedInUserData';
    
    /**
     * @var \Model\UserModel Default model for this controller. 
     */
    protected $model;
    
    /**
     * Checks if user is signed in.
     * 
     * @return boolean TRUE if user is signed in, FALSE otherwise.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    public static function isLoggedIn() {
        //Information about user login are stored in $_SESSION variable.
        if (isset($_SESSION[self::SESSION_KEY_USER_DATA]) && !empty($_SESSION[self::SESSION_KEY_USER_DATA])) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    public function __construct(bool $loadModel = true) {
        parent::__construct($loadModel);
        
        session_id(self::SESSION_ID_USER_SIGN_IN);
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
        
        if (!self::isLoggedIn()) {
            //Not logged in. Redirect login acction.
            header('Location: ' . APPLICATION_URL . $this->name . DS . 'login');
        }
        
        $this->outputHeader();
        echo 'USER profile';
        $this->outputFooter();
    }
    
    /**
     * Provides user to sign in.
     * 
     * @param array $parameters
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    public function action_login(array $parameters = []) {
        
        if (self::isLoggedIn()) {
            //Already logged in. Redirect to default acction.
            header('Location: ' . APPLICATION_URL . $this->name);
        }
        
        $this->checkPost();
        
        $this->outputHeader();
        $this->outputView('login');
        $this->outputFooter();
    }
    
    /**
     * Logs out signed in user.
     * Redirect to login action.
     * 
     * @param array $parameters
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    public function action_logout(array $parameters = []) {
        
        $this->removeUserFromSession();
        session_destroy();
        header('Location: ' . APPLICATION_URL . $this->name . DS . 'login');
    }

    /**
     * Method to check $_POST and call proper actions.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    private function checkPost() {
        
        if (!is_null(filter_input(INPUT_POST, self::FORM_NAME_SIGN_IN))) {
            $this->dealWithSignIn();
        }
    }
    
    /**
     * Prepares sign in data received from user and call model sign in method.
     * After successfully signing in redirects to user profile (index).
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    private function dealWithSignIn() {
        
        $credentials = [
            self::FIELD_LOGIN => filter_input(INPUT_POST, self::FIELD_LOGIN),
            self::FIELD_PASSWORD => filter_input(INPUT_POST, self::FIELD_PASSWORD),
        ];
        
        $result = $this->model->signIn($credentials);
        
        if (!is_null($result)) {
            $this->storeUserInSession((array)$result);
            header('Location: ' . APPLICATION_URL . $this->name . DS . 'profile');
        } else {
            $this->messages[] = 'Niepoprawne dane logowania!';
        }
    }
    
    /**
     * Removes signed in user data from session variable;
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    private function removeUserFromSession() {
        
        unset($_SESSION[self::SESSION_KEY_USER_DATA]);
    }

    /**
     * Saves signed in user data into session variable.
     * 
     * @param array $user User data from DB.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    private function storeUserInSession(array $user) {
        
        $_SESSION[self::SESSION_KEY_USER_DATA] = $user;
    }
}
