<?php

include "../Database.php";
include "../user.php";

$user = new User();
$user->setUid($_GET['id']);
$user->setUsername($_GET['name']);
$user->setPasswpord($_GET['pass']);
$user->setEmail($_GET['email']);
$user->setRoleID($_GET['roleid']);

$user->editUser($_GET['id']);

echo '<h1 class="text-center mt-5">User '.$_GET['id'].': "'.$_GET['name'].'" has been successfully updated!</h1>';


