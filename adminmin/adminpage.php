<?php 
@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name']) ){
    header('location:loginform.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <h3>hi, <span>admin</span></h3>
            <h1>welcome <span><?php echo $_SESSION['admin_name']?></span></h1>
            <p>this is an user page</p>
            <a href="loginform.php" class="btn">Login</a>
            <a href="registerform.php" class="btn"> Register</a>
            <a href="loginform.php" class="btn">Logout </a>
        </div>
    </div>
</body>
</html>