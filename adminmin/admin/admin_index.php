<?php
// admin_index.php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./snow.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>Quản Trị Viên - Trang Chủ</title>
</head>
<body>
<div class="snowflakes" aria-hidden="true">
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
    </div>

    <div class="position-sticky top-0">
        <header class="header-banner text-center h-20vh ">
            <img width="20%" src="../img/banner_left.png">
        </header>
    <nav>
        <ul>
            <li><a href="admin_books.php">Quản Lý Sách</a></li>
            <!-- <li><a href="admin_readers.php">Quản Lý Độc Giả</a></li> -->
            <li><a href="admin_borrowings.php">Quản Lý Mượn/Trả Sách</a></li>
            <li><a href="admin_users.php">Quản Lý Độc Giả</a></li>
            <li><a href="admin_index.php?logout=true" id="logout">Đăng Xuất</a></li>
        </ul>
    </nav>
    </div>
    <section class="main-content">
        <p>
            Trang Chủ dành cho Quản Trị Viên. Hãy sử dụng menu để truy cập các chức năng quản lý.
        </p>
    </section>
    <script src="../js/script.js"></script>
</body>
</body>
</html>
