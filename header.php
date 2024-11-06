
<?php
    
    session_start();
    
    if (!isset($_SESSION['UserID'])) {
        $_SESSION['UserID'] = null;
    }
    
    if (!isset($_SESSION['loggedin'])) {
        $_SESSION['loggedin'] = false;
    }
    
    if ($_SESSION['UserID'] == null || $_SESSION['loggedin'] == false) {
        $loginLink = '<a class="nav-link active text-light zoom" href="login.php">Login</a>';
        $hidden = 'd-none';
    } else {
        $loginLink = '<a class="nav-link active text-light zoom" href="logout.php">Logout</a>';
        $hidden = '';
    }
    
    if($_SESSION['RoleID'] == 1) {
        $hidden = 'd-none';
    }
    
    include 'Database.php';
    
    $db = Database::getInstance();
    $dbc = $db->connect();
     
    $result = $db->querySQL('SELECT * FROM Category');
    
    $list = "";
    if ($result) {
        $rowCount = mysqli_num_rows($result);
        if ($rowCount > 0) {
            foreach ($result as $row) {
                //echo $row;
                $list .= '<li><a class="dropdown-item text-light" href="index.php?id='.$row['CategoryID'].'">'.$row['CategoryName'].'</a></li>';
            }
        } else {
            echo "No results found.";
        }
    } else {
        echo "Error executing query: " . mysqli_error($dbc);
    }
    
    echo '
    <head>
        <meta charset="utf-8">
        <title>Gooz News</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <header>
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-white fs-2" href="index.php">GOOZ NEWS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item px-1">
                '.$loginLink.'
                </li>
                <li class="nav-item px-1">
                <a class="nav-link active text-light zoom '.$hidden.'" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item dropdown px-1">
                <a class="nav-link dropdown-toggle text-light zoom" href="#" role="button" data-bs-toggle="dropdown">
                    Topics
                </a>
                <ul data-bs-theme= "dark" class="dropdown-menu">
                    '.$list.'
                </ul>
                </li>
                <li class="nav-item px-1">
                <a class="nav-link active text-white fw-bold fst-italic zoom" href="index.php?id=1">LATEST TECH NEWS</a>
                </li>
                </ul>';
    echo        '<form class="d-flex my-0" method="GET">';
    if (isset($_GET['id'])){
        $catID =  $_GET['id']; 
        echo   '<input type="hidden" name="id" value="'.$catID.'">';
    }
    
    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
     
    if($curPageName == 'index.php') {
        echo '<input class="form-control me-2" type="search" id="search" name="search" placeholder="Search">
            <button class="btn btn-light" type="submit">Search</button>';
    }
    
    echo '</form>';
    echo' </div>
        </div>
    </nav>';

?>
