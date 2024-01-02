<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QuanLyThuVien";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý thêm độc giả mới
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addReader"])) {
    $title = $_POST["input2"];
    $author = $_POST["input5"];
    $bookCode = $_POST["input1"];
    $publishYear = $_POST["input3"];
    $quantity = $_POST["input4"]; 

    $insertReaderSql = "INSERT INTO DocGia (MaDocGia ,Ten, DiaChi, SoDienThoai, Email) 
                        VALUES ( '$bookCode','$title', '$publishYear', '$quantity', '$author')";

    if ($conn->query($insertReaderSql) === TRUE) {
        $success_message = "Độc giả đã được thêm thành công.";
    } else {
        $error_message = "Lỗi: " . $conn->error;
    }
}

// Xử lý xóa độc giả
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteReader"])) {
    $readerIdToDelete = $_POST["readerIdToDelete"];

    $deleteReaderSql = "DELETE FROM DocGia WHERE MaDocGia=$readerIdToDelete";
    
    if ($conn->query($deleteReaderSql) === TRUE) {
        $success_message = "Độc giả đã được xóa thành công.";
    } else {
        $error_message = "Lỗi: " . $conn->error;
    }
}

// Xử lý sửa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $title = $_POST["input2"];
    $author = $_POST["input5"];
    $bookCode = $_POST["input1"];
    $publishYear = $_POST["input3"];
    $quantity = $_POST["input4"]; 

    $insertBookSql = "UPDATE DocGia SET Ten = '$title', 
    DiaChi = '$publishYear', SoDienThoai = '$quantity', Email = '$author'
    WHERE MaDocGia = '$bookCode'";
    if ($conn->query($insertBookSql) === TRUE) {
    } else {
    }
}

// Lấy danh sách độc giả từ cơ sở dữ liệu
$sql = "SELECT * FROM user_form";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="user.css">
    <link rel="stylesheet" href="./snow.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>Quản Trị Viên - Quản Lý Độc Giả</title>
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
            <li><a href="admin_users.php">Quản Lý Người Dùng</a></li>
            <li><a href="" id="logout">Đăng Xuất</a></li>
        </ul>
    </nav>
    </div>
    <section class="container-fluid ">
        <div class="row pt-2 ">
            <h2 class="text-center mt-2">Quản lý Độc Giả</h2>
        </div>
        <div class="row pt-2"  style="height: 300px">
            <div class="col-sm-12 table-responsive textcontentreaders">
            <?php

            if ($result->num_rows > 0) {
                echo "<table id='table' class='table border-collapse border-secondary table-striped  table-secondary'>
                    <thead class='position-sticky top-0 z-1 table-dark'>
                        <tr>
                            <th class='text-nowrap' scope='col'>Mã Độc Giả</th>
                            <th class='text-nowrap' scope='col'>Họ Tên</th>
                            <th class='text-nowrap' scope='col'>Email</th>
                            <th class='text-nowrap' scope='col'>Số Điện Thoại</th>
                            <th class='text-nowrap' scope='col'>Email</th>
                            <th class='text-nowrap' scope='col'></th>
                        </tr>
                    </thead>
                
                <tbody class='overflow-auto'>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['Ten']}</td>
                            <td>{$row['DiaChi']}</td>
                            <td>{$row['SoDienThoai']}</td>
                            <td>{$row['Email']}</td>
                            <td>
                                <form method='post' action=''>
                                    <input type='hidden' name='readerIdToDelete' value='{$row['MaDocGia']}'>
                                    <button type='submit' name='deleteReader'>Xóa</button>
                                </form>
                            </td>
                        </tr>";
                    } echo "</tbody>
                </table>";
                } else {
                echo "<p>Không có độc giả nào.</p>";
                }

                if (isset($error_message)) {
                echo "<p class='error'>$error_message</p>";
                }
                if (isset($success_message)) {
                echo "<p class='success'>$success_message</p>";
                }
            ?>
        </div>
    </div>

<div class="row" >
    <div class="col-5 m-auto"><hr size="6px" align="center" color="#000000" /></div>
          <div class="col-2">
            <h2 class="text-center pt-4">
                <span>Thêm Độc Giả</span> 
            </h2>
         </div> 
    <div class="col-5 m-auto"><hr size="6px" align="center" color="#000000"/></div>
            
</div>

<div class="row bg-info" >
    <div class="col-sm-12 ">
        <form method="post" class="text-center p-3" action="">
            <label for="firstName">Mã Độc Giả:</label>
            <input type="text" name="input1" placeholder="Mã độc giả" required>

            <label for="lastName">Tên:</label>
            <input type="text" name="input2" placeholder="Tên" required>

            <label for="address">Địa Chỉ:</label>
            <input type="text" name="input3" placeholder="Địa chỉ" required>

            <label for="phoneNumber">Số Điện Thoại:</label>
            <input type="text" name="input4" placeholder="Số điện thoại" required>

            <label for="email">Email:</label>
            <input type="email" name="input5" placeholder="Email" required>

            <div class="button text-center m-3 ">
                <button type="submit" name="addReader" class="btn btn-primary me-5 p-2" data-toggle="button" aria-pressed="false" autocomplete="off">Thêm Độc Giả</button>
                <button type="submit" name="update" class="btn btn-primary  p-2" data-toggle="button" aria-pressed="false" autocomplete="off">Sửa Độc Giả</button>
            </div>
        </form>
    </div>
    </section>
    <script src="../js/script.js"></script>
</html>
