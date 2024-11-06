<?php

$id = $_GET['id'];

include "../Database.php";
include "../user.php";

$user = new User();

if($user->initWithUidtoEdit($id)){
    
    $user->initWithUid($id);
    
    $uid = $user->getUid();
    $username = $user->getUsername();
    $password = $user->getPassword();
    $email = $user->getEmail();
    $roleid = $user->getRoleID();
    
echo '   
            
 
                <!-- User ID --> 
                <div class="my-4">
                    <input type="text" id="userid" name="userid" class="form-control" placeholder="UserID" value="'.$uid.'" disabled readonly/>
                </div>
                
                <!-- Email input -->
                <div class="my-4">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="'.$username.'"/>
                </div>

                <!-- Password input -->
                <div class="my-4">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" value="'.$password.'" />
                </div>

                <!-- Email input -->
                <div class="my-4">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="'.$email.'" />
                </div>
                
                <!<!-- Role Select input -->
                <div class="row my-4 d-flex justify-content-around">

                        <input type="radio" class="btn-check" name="role" id="viewer" value="1" ';echo ($roleid==1) ? 'checked' : ''; echo'>
                        <label class="btn btn-outline-secondary col-10 col-md-3 mb-2" for="viewer">Viewer</label>

                        <input type="radio" class="btn-check" id="author" name="role" value="2" ';echo ($roleid==2) ? 'checked' : ''; echo'>
                        <label class="btn btn-outline-secondary col-10 col-md-3 mb-2" for="author">Author</label>
                        
                        <input type="radio" class="btn-check" id="admin" name="role" value="3" ';echo ($roleid==3) ? 'checked' : ''; echo'>
                        <label class="btn btn-outline-secondary col-10 col-md-3 mb-2" for="admin">Admin</label>

                </div>
                
                <!-- Update button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block mb-4 mx-5" 
                    onclick="updateUser(userid.value, username.value, password.value, email.value)">Update</button>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-danger btn-block mb-4 mx-5" 
                    onclick="confirmDelete(userid.value)">Delete</button>
                </div>    
            
     ';
}
?>

    

