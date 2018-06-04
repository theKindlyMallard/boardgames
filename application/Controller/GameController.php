<?php

namespace Controller;

/**
 * Game controller.
 * 
 * @author theKindlyMallard <the.kindly.mallard@gmail.com>
 */
class GameController extends Controller {
    
    /**
     * @var string Name of form field complexity.
     */
    const FIELD_COMPLEXITY = 'gameComplexity';
    /**
     * @var string Name of form field description.
     */
    const FIELD_DESCRIPTION = 'gameDescription';
    /**
     * @var string Name of form field id.
     */
    const FIELD_ID = 'gameId';
    /**
     * @var string Name of form field image.
     */
    const FIELD_IMAGE = 'gameImage';
    /**
     * @var string Name of form field play time.
     */
    const FIELD_PLAY_TIME = 'gamePlayTime';
    /**
     * @var string Name of form field players number.
     */
    const FIELD_PLAYERS_NUMBER = 'gamePlayersNumber';
    /**
     * @var string Name of form field publisher.
     */
    const FIELD_PUBLISHER = 'gamePublisher';
    /**
     * @var string Name of form field name.
     */
    const FIELD_NAME = 'gameName';
    /**
     * @var string Name of form field site URL.
     */
    const FIELD_SITE_URL = 'gameSiteUrl';
    /**
     * @var string Name of form field type.
     */
    const FIELD_TYPE = 'gameType';
    
    /**
     * @var string Name of game add form.
     */
    const FORM_NAME_GAME_ADD = 'gameAdd';
    /**
     * @var string Name of edit game form.
     */
    const FORM_NAME_GAME_EDIT = 'gameEdit';
    
    /**
     * @var \Model\GameModel Default model for this controller. 
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
        $this->outputView('list');
        $this->outputFooter();
    }
    
    public function action_add(array $parameters = []) {
        
        if (!UserController::isLoggedIn()) {
            //Not logged in. Redirect login acction.
            header('Location: ' . APPLICATION_URL . 'user' . DS . 'login');
        }
        
        $this->checkPost();
        
        $gameTypes = (array)$this->model->getGameType();
        
        $this->outputHeader();
//        $this->outputView('add');
        require DIR_VIEW . strtolower($this->name) . DS . 'add' . FILE_PHTML;
        $this->outputFooter();
    }
    
    public function action_edit(array $parameters = []) {
        
        if (!UserController::isLoggedIn()) {
            //Not logged in. Redirect login acction.
            header('Location: ' . APPLICATION_URL . 'user' . DS . 'login');
        }
        
        $this->checkPost();
        
        $gameId = $parameters[0];
        $game = $this->model->getGameByField(\Model\GameModel::COLUMN_ID, $gameId);
        $gameTypes = (array)$this->model->getGameType();
        
        $this->outputHeader();
        require DIR_VIEW . strtolower($this->name) . DS . 'edit' . FILE_PHTML;
        $this->outputFooter();
        
    }

    /**
     * Method to check $_POST and call proper actions.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    private function checkPost() {
        
        if (!is_null(filter_input(INPUT_POST, self::FORM_NAME_GAME_ADD))) {
            $this->dealWithAddNewGame();
        } else if (!is_null(filter_input(INPUT_POST, self::FORM_NAME_GAME_EDIT))) {
            $this->dealWithEditGame();
        }
    }
    
    /**
     * Prepares game data to save, call image uploading.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    private function dealWithAddNewGame() {
        
        $imagePathFromRoot = str_replace('\\', '\\\\', str_replace(DIR_ROOT, '', $this->uploadGameImage()));
        
        $gameData = [
            self::FIELD_COMPLEXITY => filter_input(INPUT_POST, self::FIELD_COMPLEXITY),
            self::FIELD_DESCRIPTION => filter_input(INPUT_POST, self::FIELD_DESCRIPTION),
            self::FIELD_IMAGE => $imagePathFromRoot,
            self::FIELD_NAME => filter_input(INPUT_POST, self::FIELD_NAME),
            self::FIELD_PLAYERS_NUMBER => filter_input(INPUT_POST, self::FIELD_PLAYERS_NUMBER),
            self::FIELD_PLAY_TIME => filter_input(INPUT_POST, self::FIELD_PLAY_TIME),
            self::FIELD_PUBLISHER => filter_input(INPUT_POST, self::FIELD_PUBLISHER),
            self::FIELD_SITE_URL => filter_input(INPUT_POST, self::FIELD_SITE_URL),
            self::FIELD_TYPE => filter_input(INPUT_POST, self::FIELD_TYPE),
        ];
        
        $result = $this->model->saveGame($gameData);
        
        if ($result > 0) {
            $this->messages['ok'] = 'Game saved with ID ' . $result;
        } else {
            $this->messages['error'] = 'Some errors occured. Game not saved.';
        }
    }
    
    /**
     * Prepares game data to save, call image uploading.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    private function dealWithEditGame() {
        
        $imagePathFromRoot = str_replace('\\', '\\\\', str_replace(DIR_ROOT, '', $this->uploadGameImage()));
        
        $gameData = [
            self::FIELD_COMPLEXITY => filter_input(INPUT_POST, self::FIELD_COMPLEXITY),
            self::FIELD_DESCRIPTION => filter_input(INPUT_POST, self::FIELD_DESCRIPTION),
            self::FIELD_IMAGE => $imagePathFromRoot,
            self::FIELD_NAME => filter_input(INPUT_POST, self::FIELD_NAME),
            self::FIELD_PLAYERS_NUMBER => filter_input(INPUT_POST, self::FIELD_PLAYERS_NUMBER),
            self::FIELD_PLAY_TIME => filter_input(INPUT_POST, self::FIELD_PLAY_TIME),
            self::FIELD_PUBLISHER => filter_input(INPUT_POST, self::FIELD_PUBLISHER),
            self::FIELD_SITE_URL => filter_input(INPUT_POST, self::FIELD_SITE_URL),
            self::FIELD_TYPE => filter_input(INPUT_POST, self::FIELD_TYPE),
            self::FIELD_ID => filter_input(INPUT_POST, self::FIELD_ID),
        ];
        
        $result = $this->model->editGame($gameData);
        
        if ($result > 0) {
            $this->messages['ok'] = 'Game with ID ' . $result . ' edited.';
        } else {
            $this->messages['error'] = 'Some errors occured. Game not saved (edited).';
        }
    }
    
    /**
     * Gets file data from sent form and try to upload it on server.
     * 
     * @return string Path to uploaded image or empty string if not uploaded.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    private function uploadGameImage() {
        
        $target_file = DIR_IMAGES_GAMES . basename($_FILES[self::FIELD_IMAGE]['name']);
        $uploadOk = 1;

        $check = getimagesize($_FILES[self::FIELD_IMAGE]['tmp_name']);
        if($check !== false) {
            //"File is an image - " . $check['mime'] . ".";
            $uploadOk = 1;
        } else {
            //"File is not an image.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //echo "Sorry, your file was not uploaded.";
            $picturePath = '';
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES[self::FIELD_IMAGE]['tmp_name'], $target_file)) {
                //"The file ". basename( $_FILES["picture"]["name"]). " has been uploaded.";
                $picturePath = $target_file;
            } else {
                //"Sorry, there was an error uploading your file.";
                $picturePath = '';
            }
        }
        
        return $picturePath;
    }
}
