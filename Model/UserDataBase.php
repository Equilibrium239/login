<?php
require_once 'vendor/autoload.php';
 
class UserDatabase {
    private $pdo;
    private $auth;
 
    function getAuth(){
      return $this->auth;
    }
    function __construct($pdo) {
        $this->pdo = $pdo;
        $this->auth = new \Delight\Auth\Auth($pdo);
    }
 
    function setupUsers(){
    }
    
    
    
    function seedUsers(){
        if($this->pdo->query("select * from users where email='stefan.holmberg@systementor.se'")->rowCount() == 0){
            $userId = $this->auth->admin()->createUser("stefan.holmberg@systementor.se", "Hejsan123#", "stefan.holmberg@systementor.se");    
        }
    }
    
}
 
?>