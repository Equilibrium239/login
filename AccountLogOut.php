<?php
 ob_start();
require_once('Model/Database.php');
 
$database = new Database();
$database->getUsersDatabase()->getAuth()->logOut();
 
header("Location: /");
exit();
 
?>