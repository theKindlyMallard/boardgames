<?php

namespace Model;

/**
 * Model of user.
 * 
 * @author theKindlyMallard <the.kindly.mallard@gmail.com>
 */
class UserModel extends Model {
    
    /**
     * Provides user to sign in.
     * 
     * @param array $credentials Data needed to log in.
     * @return stdClass|null User object from DB or NULL if unable to log in.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    public function signIn(array $credentials) {
        
        if ($this->validateSighIn($credentials)) {
            
            $pdo = $this->getConnection();
            $sql = 'SELECT * FROM `' . DB_NAME . '`.`user` WHERE `login` = :login AND `password` = :pass';
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'login' => $credentials[\Controller\UserController::FIELD_LOGIN],
                'pass' => $credentials[\Controller\UserController::FIELD_PASSWORD],
            ]);
            $result = $statement->fetchAll(\PDO::FETCH_OBJ);
            
            if (count($result) > 0) {
                return array_shift($result);
            }
        }
        
        return null;
    }
    
    /**
     * Validates given sign in data.
     * 
     * @param array $data Data to validate.
     * @return boolean TRUE if data is valid, FALSE otherwise.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    private function validateSighIn(array $data) {
        
        $valid = true;
        
        if (!isset($data[\Controller\UserController::FIELD_LOGIN])
                || empty($data[\Controller\UserController::FIELD_LOGIN])) {
            $valid = false;
        } else if (!isset($data[\Controller\UserController::FIELD_PASSWORD])
                || empty($data[\Controller\UserController::FIELD_PASSWORD])) {
            $valid = false;
        }
        
        return $valid;
    }
}
