<?php

include "../Database.php";
include "../user.php";

$uid = urldecode($_GET['id']);

$user = new User();
$user->initWithUid($uid);

echo '<h1 class="text-center mt-5">User '.$uid.': "'.$user->getUsername().'" has been successfully deleted!</h1>';

$user->deleteUser();

