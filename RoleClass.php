<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RoleClass
 *
 * @author User
 */
class RoleClass {
    private $RoleID;
    private $Role;
    
    public function __construct() {
        $this->RoleID = null;
        $this->Role = null;
    }

    public function getRoleID() {
        return $this->RoleID;
    }

    public function getRole() {
        return $this->Role;
    }

    public function setRoleID($RoleID) {
        $this->RoleID = $RoleID;
    }

    public function setRole($Role) {
        $this->Role = $Role;
    }

        
    function intWithId($id) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM Role WHERE RoleID = ' . $id);
        $this->initWith($data->RoleID, $data->Role);
    }    
    
    function intWithRole($role) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM Role WHERE Role = ' . $role);
        $this->initWith($data->RoleID, $data->Role);
    }
    
    function insertRole($role){
        try {
            $db = Database::getInstance();
            $data = $db->querySql('INSERT INTO Role (RoleID, RoleName) VALUES '
                    . '(NULL, ' . $role . '\')');
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    function deleteRole() {
        try {
            $db = Database::getInstance();
            $data = $db->querySql('Delete from Role where RoleID=' . $this->RoleID);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
}
