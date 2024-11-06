<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of User
 *
 * @author 201901579
 */
class User {
    //put your code here
    private $UserID;
    private $Username;
    private $Email;
    private $Password;
    private $RoleID;
    
    function _construct() {
        $this->UserID = null;
        $this->Username = null;
        $this->Email = null;
        $this->Password = null;
        $this->RoleID = null;
    }
    
    function setUid ($uid){
        $this->UserID = $uid;
    }
    
    function setUsername ($username){
        $this->Username = $username;
    }
    
    function setPasswpord ($password){
        $this->Password = $password;
    }
    
    function setEmail ($email){
        $this->Email = $email;
    }
    
    function setRoleID ($roleID){
        $this->RoleID = $roleID;
    }
    
    function getRoleID(){
        return $this->RoleID;
    }
    
    function getUid(){
        return $this->UserID;
    }
    
    function getUsername(){
        return $this->Username;
    }
    
    function getPassword(){
        return $this->Password;
    }
    
    function getEmail(){
        return $this->Email;
    }
    
    function initWithUid($uid) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM User WHERE UserID = ' . $uid);
        $this->initWith($data->UserID, $data->UserName, $data->Password, $data->Email, $data->RoleID);
//        echo 'fetched user with username ' . $this->Username; //DEBUGGING STATEMENT
        
    }
    
    function initWithUidtoEdit($uid) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM User WHERE UserID = ' . $uid);
//        echo 'fetched user with username ' . $this->Username; //DEBUGGING STATEMENT
        if($data != null) {
            return true;
        } else {
            return false;
        }
        
    }
    
    function initWithUsername() {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM User WHERE UserName = \'' . $this->Username . '\'');
        if ($data != null) {
            return false;
        }
            return true;
    }
    
    function initWith($uid, $username, $password, $email, $roleid){
        $this->UserID = $uid;
        $this->Password = $password;
        $this->Username = $username;
        $this->Email = $email;
        $this->RoleID = $roleid;
    }
    
    function registerUser(){
        if($this->isValid()) {
            try{
                Database::getInstance()->querySql('INSERT INTO User (UserID, UserName, Password, Email, RoleID)'. ' VALUES (NULL, '
                    . '\''   . $this->Username 
                    . '\',\'' . $this->Password 
                    . '\',\'' . $this->Email 
                    . '\',\'' . $this->RoleID . '\')');
                return true;
            } catch (Exception $ex) {
                echo 'Exception: ' . $ex;
                return false;
            }
        } else {
            echo 'this is invalid';
            return false;
        }
    }
    
    function editUser($userID) {
        if ($this->isValidID($userID)) {
            try {
                Database::getInstance()->querySql('UPDATE User SET'
                    . ' UserName = \'' . $this->Username 
                    . '\', Password = \'' . $this->Password 
                    . '\', Email = \'' . $this->Email 
                    . '\', RoleID = \'' . $this->RoleID 
                    . '\' WHERE UserID = ' . $userID);

                return true;
            } catch (Exception $ex) {
                echo 'Exception: ' . $ex;
                return false;
            }
        } else {
            echo 'This is invalid';
            return false;
        }
    }

     
    function updateDB() {
        if($this->isValid()) {
            Database::getInstance()->querySql('UPDATE User set '
                    . 'Email = \'' . $this->email .'\','
                    . 'UserName = \'' . $this->username . '\','
                    . 'Password = \'' . $this->password . '\''
                    . ' WHERE UserID = ' . $this->uid);
            echo 'update called';
        }
    }
    
    function deleteUser() {
        try {
            Database::getInstance()->querySql('Delete from User where UserID = ' .$this->UserID);
            return true;
        } catch (Exception $ex) {
            echo 'Error deleting: ' . $ex;
            return false;
        }
    }
    
    public function isValidID($uid) {
        $errors = true;
        
        if(empty($this->Username)) {
            $errors = false; 
            echo 'empty username';
        }
        else {
            if (!$this->initWithUidtoEdit($uid)) {
                $errors = false;
                echo 'init failed + ';
            }
            
            if (empty($this->Email)) {
                $errors = false;
                echo 'empty email';
            }     
            if (empty($this->Password)) {
                $errors = false;
                echo 'empty password';
            }
            return $errors;
        }
    }
    
    public function isValid() {
        $errors = true;
        
        if(empty($this->Username)) {
            $errors = false; 
            echo 'empty username';
        }
        else {
            if (!$this->initWithUsername()) {
                $errors = false;
                echo 'init failed';
            }
            
            if (empty($this->Email)) {
                $errors = false;
                echo 'empty email';
            }     
            if (empty($this->Password)) {
                $errors = false;
                echo 'empty password';
            }
            return $errors;
        }
    }
    
    function checkUser($username, $password) {
        
        $data = Database::getInstance()->singleFetch(
                'SELECT * FROM User WHERE UserName = \'' .$username
                .'\' AND Password = \'' .$password .'\'');
        $this->initWith($data->UserID, $data->UserName, $data->Password, $data->Email, $data->RoleID);
        
        if ($this->Username != '') {
            echo $this->Username;
            echo $this->UserID;
        } else  {
            echo 'check failed';
        }
        
    }
    
    function login() {
            
        try {
            
            if($this->UserID != null) {
                
                $this->checkUser($this->Username, $this->Password);
                $_SESSION['UserID'] = $this->getUid();
                $_SESSION['UserName'] = $this->getUsername();
                $_SESSION['RoleID'] = $this->RoleID;
                echo '<br>username: '.$username
                        .'password: '.$password;
                 
                return true;
                
            } else {
                $error[] = 'Wrong username or password';
                return false;
            }
            
        } catch (Exception $ex) {
            $error[] = $ex->getMessage();
        }
        
        return false;
    }
    
    function logout() {
        $_SESSION['UserID'] = '';
        $_SESSION['UserName'] = '';
        $_SESSION['RoleID'] = '';
        
        session_destroy();
    }
    
    public function getAllUsers(){
        
        $db = Database::getInstance();
        $dbc = $db->connect();
        
        $result = $db->querySQL("SELECT * FROM User");

        foreach ($result as $row) {

            //UserID, UserName, Password, Email, RoleID
            $user = new User();
            $user->setUid($row['UserID']);
            $user->setUsername($row['UserName']);
            $user->setPasswpord($row['Password']);
            $user->setEmail($row['Email']);
            $user->setRoleID($row['RoleID']);

            $users[] = $user;
            
            //Uncomment to find out what the query is returning
            //var_dump($row);
        }
        
        return $users;
        
    }
    
    public function searchUsers($q){
        
        $db = Database::getInstance();
        $dbc = $db->connect();
        
        $result = $db->querySQL("SELECT * FROM User WHERE UserName LIKE '%".$q."%' OR UserID LIKE '%".$q."%'");

        foreach ($result as $row) {

            //UserID, UserName, Password, Email, RoleID
            $user = new User();
            $user->setUid($row['UserID']);
            $user->setUsername($row['UserName']);
            $user->setPasswpord($row['Password']);
            $user->setEmail($row['Email']);
            $user->setRoleID($row['RoleID']);

            $users[] = $user;
            
            //Uncomment to find out what the query is returning
            //var_dump($row);
        }
        
        return $users;
        
    }
    
}
