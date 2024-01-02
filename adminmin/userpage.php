<?php 
@include 'config.php';

session_start();

if(!isset($_SESSION['user_name']) ){
    header('location:loginform.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="userpage.css">
</head>
<body>
    <div class="container-fluid">
       <div class="row">
            <header class="header-banner text-center  ">
                <img width="25%" src="./img/banner_left.png">
            </header>
       </div>
            
    </div>

    <section class="container-fluid ">
        <div class=" row bg-info ">
            <div class="col-sm-3 "><a href="userpage.php" class="text-nav">Trang chủ</a></div>
            <div class="col-sm-3 "><a href="introducepage.php" class="text-nav" id="gt">Giới thiệu</a></div>
            <div class="col-sm-3 "><a href="instructpage.php" class="text-nav">Hướng dẫn</a></div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row pt-2" style="height: 1100px">
            <div class="col-sm-2 text-black img-user">
                <div class="img-userpage"><img src="./img/userpage.png" alt=""></div>
                <h5><span>user</span></h5>
                <h5> <i class="bi bi-person-hearts"></i> <span><?php echo $_SESSION['user_name']?></span></h5>

                <a href=""><h5> <i class="bi bi-book text-userpage">Sách trong thư viện </i></h5></a>
                <a href="loginform.php" class="btn">Login <i class="bi bi-door-open"></i></a>
                <a href="registerform.php" class="btn"> Register <i class="bi bi-r-square-fill"></i></a>
                <a href="logout.php" class="btn">Logout <i class="bi bi-door-closed-fill"></i></a>
            </div>
            <div class="col-sm-10 bg-success text-white"></div>
        </div>
    </section>

    
</body>
</html>