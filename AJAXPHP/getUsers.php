<?php
//this script is called by AJAX using the GET method
$q = $_GET["q"];

include "../Database.php";
include "../user.php";


$user = new User();
$users = $user->searchUsers($q);

echo '<table class="table col-4 table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>';

foreach ($users as $user) {
        
$uid = $user->getUid();
$username = $user->getUsername();
$password = $user->getPassword();
$email = $user->getEmail();
$roleid = $user->getRoleID();
        
switch ($roleid) {
    case 3:
        $roleid = 'Admin';
        break;
    case 2:
        $roleid = 'Author';
        break;
    case 1:
        $roleid = 'Viewer';
        break;
    default:
        $roleid = 'undefined';
        break;
}

echo "<tr onclick=\"showUserControls($uid)\">
        <td>$uid</td>
        <td>$username</td>
        <td>$password</td>
        <td>$email</td>
        <td>$roleid  </td>
      </tr>";            
}

echo "</tbody></table>"
?>

