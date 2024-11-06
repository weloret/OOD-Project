<?php
include 'header.php';
//include './Database.php'; 
include './user.php';
// check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Connect to the database
    $db = Database::getInstance();
    $dbc = $db->connect(); 
    
    //Prepare the SQL query to check if the user exists
    $user = new User();
    
        echo $username;
        echo $password;
        
        $user->checkUser($username, $password); 
        //Check if the entered password matches the hashed password in the database
        if($user->login($username, $password)) {
            //Passwords match, so log in the user
            $_SESSION["loggedin"] = true; 
            $_SESSION["username"] = $username;
            $_SESSION["UserID"] = $user->getUid();
            header("Location: index.php");
        } else {
            //Passwords don't match, so show an error message
            $login_err = "Invalid password.";
            echo 'error'; 
        }
}
?>

<html>

<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    
    <ul class="mt-4 nav nav-tabs justify-content-center" id="navtabs">
        <li class="nav-item">
            <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login-tab-pane">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="register-tab" data-bs-toggle="tab" href="#register-tab-pane">Register</a>
        </li>
    </ul>
    
    <div class="row tab-content justify-content-center">
        <div class="tab-pane fade show active col-10 col-md-6" id="login-tab-pane">
            <form action="login.php" method="post">

                <!-- Name input -->
                <div class="my-4">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required />
                </div>

                <!-- Password input -->
                <div class="mb-4">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required />
                </div>

                <!-- Submit button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-secondary btn-block mb-4">Sign in</button>
                </div>
            </form>
        </div>
        
        <div class="tab-pane fade col-10 col-md-6" id="register-tab-pane">
            <form action="register.php" method="post">
 
                <!-- Email input -->
                <div class="my-4">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required />
                </div>

                <!-- Password input -->
                <div class="mb-4">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required />
                </div>

                <!-- Email input -->
                <div class="my-4">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" required />
                </div>
                
                <!<!-- Role Select input -->
                <div class="row my-4 d-flex justify-content-around">

                        <input type="radio" class="btn-check" name="role" id="viewer" value="1">
                        <label class="btn btn-outline-secondary col-10 col-md-5 mb-2" for="viewer">Viewer</label>

                        <input type="radio" class="btn-check" id="author" name="role" value="2">
                        <label class="btn btn-outline-secondary col-10 col-md-5 mb-2" for="author">Author</label>

                </div>

                <!-- Submit button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block mb-4">Register</button>
                </div>
            </form>
  </div>
</div>
</body>

</html>