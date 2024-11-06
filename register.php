<?php
include 'header.php';
//include './Database.php';
include './user.php';
// check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $roleID = $_POST['role'];
    
    //Connect to the database
    $db = Database::getInstance();
    $dbc = $db->connect(); 
    
    //Prepare the SQL query to check if the user exists
    $user = new User();
    
    $user->setUsername($username);
    $user->setPasswpord($password);
    $user->setEmail($email);
    $user->setRoleID($roleID);


    if($user->registerUser()) {
        header("Location: index.php");
    }
    
}
?>