<?php 
require_once 'vendor/autoload.php';
require_once 'Model/UserDataBase.php';

class Database {
        public $pdo; // PDO är PHP Data Object - en klass som finns i PHP för att kommunicera med databaser
        // I $pdo finns nu funktioner (dvs metoder!) som kan användas för att kommunicera med databasen
 
        private $usersDatabase;
        function getUsersDatabase(){
            return $this->usersDatabase;
        }        
 
        
        // Note to Stefan STATIC så inte initieras varje gång
        
        // SKILJ PÅ CONFIGURATION OCH KOD
 
        function __construct() {    
                $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
                $dotenv->load();

            $host = $_ENV['DB_HOST'];
            $db   = $_ENV['DB_DATABASE'];
            $user = $_ENV['DB_USERNAME'];
            $pass = $_ENV['DB_PASSWORD'];
            $port = $_ENV['DB_PORT'];
 
            $dsn = "mysql:host=$host:$port;dbname=$db"; // connection string
            $this->pdo = new PDO($dsn, $user, $pass);
 
     $this->usersDatabase = new UserDatabase($this->pdo);
     $this->usersDatabase->setupUsers();
     $this->usersDatabase->seedUsers();
 
        }

        function addUserDetails($id, $streetaddress, $name, $postalCode, $city){
            $query = $this->pdo->prepare("INSERT INTO UserDetails (id, streetaddress, name, postalCode, city) VALUES (:id, :streetaddress, :name, :postalCode, :city)");
            $query->execute(["id"=>$id, "streetaddress"=>$streetaddress, 
            "name"=>$name, "postalCode"=>$postalCode, "city"=>$city]);
        }

 }

?>