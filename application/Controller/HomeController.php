<?php

namespace Controller;

/**
 * Home controller.
 * 
 * @author theKindlyMallard <the.kindly.mallard@gmail.com>
 */
class HomeController extends Controller {
    
    /**
     * @var string Name of form field e-mail.
     */
    const FIELD_EMAIL = 'contactEmail';
    /**
     * @var string Name of form field name.
     */
    const FIELD_NAME = 'contactName';
    /**
     * @var string Name of form field message.
     */
    const FIELD_MESSAGE = 'contactMessage';
    
    /**
     * @var string Name of sign in form.
     */
    const FORM_NAME_CONTACT = 'homeContact';
    
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
    
    public function action_contactUs(array $parameters = []) {
        
        $this->checkPost();
        
        $this->outputHeader();
        $this->outputView('contact');
        $this->outputFooter();
    }

    /**
     * Method to check $_POST and call proper actions.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    private function checkPost() {
        
        if (!is_null(filter_input(INPUT_POST, self::FORM_NAME_CONTACT))) {
            $this->dealWithContact();
        }
    }
    
    /**
     * Sends an e-mail message from contact form.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    private function dealWithContact() {
        
        $formName = filter_input(INPUT_POST, self::FIELD_NAME);
        $formEmail = filter_input(INPUT_POST, self::FIELD_EMAIL);
        $formMessage = filter_input(INPUT_POST, self::FIELD_MESSAGE);
        
        $subject = 'Message from contact form';
        $message = nl2br(
            "Imie:  $formName
            \nE-mail:  $formEmail
            \nWiadomosc:  $formMessage"
        );
        $headers = 'Content-Type: text/HTML; charset=utf-8';
        //Send mail.
        $result = mail(
            'the.kindly.mallard@gmail.com',
            $subject,
            $message,
            $headers
        );

        if (!$result) {
            $this->messages['ok'] = 'Thanks, the pigeon is just delivering your message.';
        } else {
            $this->messages['error'] = 'Something goes wrong. Maybe You found new bug?';
        }
    }
}
