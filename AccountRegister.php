<?php
ob_start();
require_once('Utils/Validator.php');
require_once('Model/Database.php');
require_once('lib/PageTemplate.php');
# trick to execute 1st time, but not 2nd so you don't have an inf loop
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Regsier";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}
$v = new Validator($_POST);
 
$database = new Database();
$email = "";
$password = "";
$passwordRepeat = "";
$name ="";
$streetaddress = "";
$postalCode = "";
$city = "";  
 
$message = "";
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dom har tryckt på knappen, validera och registrera
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['repeat_password'];
    $name = $_POST['name'];
    $streetaddress = $_POST['street'];
    $postalCode = $_POST['postal'];
    $city = $_POST['city'];
 
    // todo add 
    $v->field('email')->required()->email();
    $v->field('password')->required()->min_len(8)->max_len(20);
    $v->field('repeat_password')->equals($password);
 
    $v->field('name')->required()->min_len(3)->max_len(50);
    $v->field('street')->required()->min_len(3)->max_len(50);
    $v->field('postal')->required()->max_len(10);
    $v->field('city')->required()->max_len(50);
    
    //
    if($v->is_valid()){
        try{
            $userid = $database->getUsersDatabase()->getAuth()->register($email, $password,$email);
        // insert into user details table with $userid and other details
            $database->addUserDetails($userid, $name, $streetaddress, $postalCode, $city);
            header("Location: /AccountLogin.php");
            exit;
            }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $message = "User already exists";
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $message = "Invalid email";
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $message = "Too many requests, please try again later";
        }
    }
}
 


?>
<p>
<div class="row">

<div class="row">
                <div class="col-md-12">
                    <div class="newsletter">
                        <p>User<strong>&nbsp;REGISTER</strong></p>
                        <form method="post">
                            <input class="input" type="email" name="email" placeholder="Enter Your Email">
                            <br/>
                         
                                <span class="error"><?php echo $v->get_error_message('email'); ?></span>
                        
                            <br/>
                            <input class="input" type="password" name="password" placeholder="Enter Your Password">
                            <br/>
                     
                                <span class="error"><?php echo $v->get_error_message('password'); ?></span>
                      
                            <br/>
                            <input class="input" type="password" name="repeat_password" placeholder="Repeat Password">
                            <br/>
                  
                                <span class="error"><?php echo $v->get_error_message('repeat_password'); ?></span>
                           
                            <br/>
                            <input class="input" type="name" name="name" placeholder="Name">
                            <br/>
                            <span class="error"><?php echo $v->get_error_message('name'); ?></span>
                            <br/>
                            <input class="input" type="street" name="street" placeholder="Street address">
                            <br/>
                            <span class="error"><?php echo $v->get_error_message('street'); ?></span>
                            <br/>
                            <input class="input" type="postal" name="postal" placeholder="Postal code">
                            <br/>
                            <span class="error"><?php echo $v->get_error_message('postal'); ?></span>
                            <br/>
                            <input class="input" type="city" name="city" placeholder="City">
                            <br/>
                            <span class="error"><?php echo $v->get_error_message('city'); ?></span>
                            <br/>
                            <button class="newsletter-btn"><i class="fa fa-envelope"></i> Register</button>
                        </form>
                    </div>
                </div>
            </div>


</div>
    

</p>