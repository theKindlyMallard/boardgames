<?php
namespace Model;
/**
 * Model of game.
 * 
 * @author theKindlyMallard <the.kindly.mallard@gmail.com>
 */
class GameModel extends Model {
    /**
     * @var string Name of column complexity.
     */
    const COLUMN_COMPLEXITY = 'complexity';
    /**
     * @var string Name of column description.
     */
    const COLUMN_DESCRIPTION = 'description';
    /**
     * @var string Name of column id.
     */
    const COLUMN_ID = 'id';
    /**
     * @var string Name of column image.
     */
    const COLUMN_IMAGE = 'image';
    /**
     * @var string Name of column play time.
     */
    const COLUMN_PLAY_TIME = 'play_time';
    /**
     * @var string Name of column players number.
     */
    const COLUMN_PLAYERS_NUMBER = 'players_number';
    /**
     * @var string Name of column publisher.
     */
    const COLUMN_PUBLISHER = 'publisher';
    /**
     * @var string Name of column name.
     */
    const COLUMN_NAME = 'name';
    /**
     * @var string Name of column site URL.
     */
    const COLUMN_SITE_URL = 'site_url';
    /**
     * @var string Name of column type.
     */
    const COLUMN_TYPE = 'fk_type';
    /**
     * @var string Name of column user.
     */
    const COLUMN_USER = 'fk_user';
    
    /**
     * Gets user by field value e.g. ID.
     * 
     * @param string $field Field name for which get game (column name).
     * @param type $value Value to search for in field.
     * @return null|stdClass|array[stdClass] Returns single object if specified ID given or
     *              array of objects if no ID given or NULL if no results.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    public function getGameByField(string $field, $value) {
        
        $pdo = $this->getConnection();
        $sql = 'SELECT * FROM `' . DB_NAME . "`.`game` WHERE `$field` = '$value'";
        
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        if (count($result) == 0) {
            return null;
        } else if (count($result) == 1) {
            return array_shift($result);
        } else {
            return $result;
        }
    }
    
    /**
     * Gets game type from DB.
     * 
     * @param int $id ID of game type to get. Leave set to 0 if want get all.
     * @return null|stdClass|array[stdClass] Returns single object if specified ID given or
     *              array of objects if no ID given or NULL if no results.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    public function getGameType(int $id = 0) {
        
        $pdo = $this->getConnection();
        $sql = 'SELECT * FROM `' . DB_NAME . '`.`game_type`';
        $sql .= ($id > 0) ? " WHERE `id` = $id" : '';
        
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        if (count($result) == 0) {
            return null;
        } else if (count($result) == 1) {
            return array_shift($result);
        } else {
            return $result;
        }
    }
    
    /**
     * Edit game info.
     * 
     * @param array $gameData Game data to save.
     * @return int|bool Game ID or FALSE on failure.
     * 
     * @todo Better validation.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    public function editGame(array $gameData) {
        
        if (\Controller\UserController::isLoggedIn()) {
            $userId = $_SESSION[\Controller\UserController::SESSION_KEY_USER_DATA]['id'];
        } else {
            return false;
        }
        
        $gameDataValues = [
            self::COLUMN_COMPLEXITY => $gameData[\Controller\GameController::FIELD_COMPLEXITY],
            self::COLUMN_DESCRIPTION => $gameData[\Controller\GameController::FIELD_DESCRIPTION],
            self::COLUMN_IMAGE => $gameData[\Controller\GameController::FIELD_IMAGE],
            self::COLUMN_NAME => $gameData[\Controller\GameController::FIELD_NAME],
            self::COLUMN_PLAYERS_NUMBER => $gameData[\Controller\GameController::FIELD_PLAYERS_NUMBER],
            self::COLUMN_PLAY_TIME => $gameData[\Controller\GameController::FIELD_PLAY_TIME],
            self::COLUMN_PUBLISHER => $gameData[\Controller\GameController::FIELD_PUBLISHER],
            self::COLUMN_SITE_URL => $gameData[\Controller\GameController::FIELD_SITE_URL],
            self::COLUMN_TYPE => $gameData[\Controller\GameController::FIELD_TYPE],
            self::COLUMN_USER => $userId,
            self::COLUMN_ID => $gameData[\Controller\GameController::FIELD_ID],
        ];
        
        return $this->updateGameData($gameDataValues);
    }
    
    /**
     * Saves new game info.
     * 
     * @param array $gameData Game data to save.
     * @return int|bool Game ID or FALSE on failure.
     * 
     * @todo Better validation.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    public function saveGame(array $gameData) {
        
        if (\Controller\UserController::isLoggedIn()) {
            $userId = $_SESSION[\Controller\UserController::SESSION_KEY_USER_DATA]['id'];
        } else {
            return false;
        }
        
        $gameDataValues = [
            self::COLUMN_COMPLEXITY => $gameData[\Controller\GameController::FIELD_COMPLEXITY],
            self::COLUMN_DESCRIPTION => $gameData[\Controller\GameController::FIELD_DESCRIPTION],
            self::COLUMN_IMAGE => $gameData[\Controller\GameController::FIELD_IMAGE],
            self::COLUMN_NAME => $gameData[\Controller\GameController::FIELD_NAME],
            self::COLUMN_PLAYERS_NUMBER => $gameData[\Controller\GameController::FIELD_PLAYERS_NUMBER],
            self::COLUMN_PLAY_TIME => $gameData[\Controller\GameController::FIELD_PLAY_TIME],
            self::COLUMN_PUBLISHER => $gameData[\Controller\GameController::FIELD_PUBLISHER],
            self::COLUMN_SITE_URL => $gameData[\Controller\GameController::FIELD_SITE_URL],
            self::COLUMN_TYPE => $gameData[\Controller\GameController::FIELD_TYPE],
            self::COLUMN_USER => $userId,
        ];
        
        return $this->saveGameData($gameDataValues);
        
    }
    
    /**
     * Saves game into DB.
     * 
     * @param array $gameData Game data to save.
     * @return int|bool Saved game ID or FALSE on failure.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    private function saveGameData(array $gameData) {
        
        $pdo = $this->getConnection();
        
        $sql = "INSERT INTO `" . DB_NAME . "`.`game` " . 
            "(" 
            . self::COLUMN_COMPLEXITY . ", " 
            . self::COLUMN_DESCRIPTION . ", " 
            . self::COLUMN_IMAGE . ", " 
            . self::COLUMN_NAME . ", " 
            . self::COLUMN_PLAYERS_NUMBER . ", " 
            . self::COLUMN_PLAY_TIME . ", " 
            . self::COLUMN_PUBLISHER . ", " 
            . self::COLUMN_SITE_URL . ", " 
            . self::COLUMN_TYPE . ", " 
            . self::COLUMN_USER . " " 
            .") " . 
            "VALUES (" .
            "'" . $gameData[self::COLUMN_COMPLEXITY] . "', " .
            "'" . $gameData[self::COLUMN_DESCRIPTION] . "', " .
            "'" . $gameData[self::COLUMN_IMAGE] . "', " .
            "'" . $gameData[self::COLUMN_NAME] . "', " .
            "'" . $gameData[self::COLUMN_PLAYERS_NUMBER] . "', " .
            "'" . $gameData[self::COLUMN_PLAY_TIME] . "', " .
            "'" . $gameData[self::COLUMN_PUBLISHER] . "', " .
            "'" . $gameData[self::COLUMN_SITE_URL] . "', " .
            "'" . $gameData[self::COLUMN_TYPE] . "', " .
            "'" . $gameData[self::COLUMN_USER] . "'" .
            ")";
        
        return $pdo->query($sql) ? $pdo->lastInsertId() : false;
    }
    
    /**
     * Update game into DB.
     * 
     * @param array $gameData Game data to save.
     * @return int|bool Updated game ID or FALSE on failure.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    private function updateGameData(array $gameData) {
        
        $pdo = $this->getConnection();
        
        $sql = "UPDATE `" . DB_NAME . "`.`game` " . " SET ";
        //Add all values to update to query.
        foreach ($gameData as $columnName => $value) {
            //Do not save this fields again.
            if ($columnName == self::COLUMN_ID) {
                continue;
            }
            $sql .= "`$columnName` = '$value', ";
        }
        //Remove necessary colon at the and.
        $sql = substr_replace($sql, '', -2, 1);
        $sql .= "WHERE `" . self::COLUMN_ID . "` = '" . $gameData[self::COLUMN_ID] . "';";
        
        $statement = $pdo->query($sql);
        
        if ($statement && $statement->rowCount() > 0) {
            //Get updated user ID.
            $game = $this->getGameByField(self::COLUMN_ID, $gameData[self::COLUMN_ID]);
            return $game->id;
        }
        
        //There were some errors.
        return false;
    }
}
