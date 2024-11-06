<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

include 'header.php';
//include 'Database.php';
include 'user.php';
include 'ArticleClass.php';

$user = new User();
$user->initWithUid($_SESSION['UserID']);

if($_SESSION['RoleID'] == 3) { //if user is admin show admin dashboard
    
    include 'admin_dash.php';
    
} elseif ($_SESSION['RoleID'] == 2) { //if user is author show author dashboard
    
    include 'author_dash.php';
    
} else { //ask user to sign in
    echo 'not logged in';
}