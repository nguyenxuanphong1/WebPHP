<?php
// manage_readers.php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QuanLyThuVien";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}



$user_Id = $_SESSION["id"] ?? null; // Assuming you have a user ID stored in the session
$sql = "SELECT * FROM user_form WHERE id = '$user_Id' ";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="user.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>Quản Lý Thư Viện - Thông Tin Độc Giả</title>
</head>
<body>
    <div class="container-fluid">
       <div class="row">
            <header class="header-banner text-center h-20vh ">
                <img width="25%" src="../img/banner_left.png">
            </header>
       </div>
    </div>
    <section class="container-fluid ">
        <div class=" row bg-info ">
            <div class="col-sm-3 "><a href="books.php" class="text-nav">Sách</a></div>
            <div class="col-sm-3 "><a href="readers.php" class="text-nav">Độc Giả</a></div>
            <div class="col-sm-3 "><a href="historybook.php" class="text-nav">Lịch Sử Mượn Sách</a></div>
            <div class="col-sm-3 "><a href="introducepage.php" class="text-nav" id="gt">Giới thiệu</a></div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row pt-2" style="height: 800px">
            <div class="col-sm-2 text-black img-user">
                <div class="img-userpage"><img src="../img/userpage.png " alt=""></div>
                <h5><span>user</span></h5>
                <h5> <i class="bi bi-person-hearts"></i> <span><?php echo $_SESSION['user_name']?>-<?php echo $_SESSION['id']?></span></h5>

                <a href="../loginform.php" class="btn">Thoát <i class="bi bi-door-open"></i></a>
            </div>
            <div class="col-sm-10 bg-success text-white">
                <div class="row">
                    <h3 class="text-center ">Thông Tin Độc Giả</h3>
                </div>
                
            <div class="row pt-2"  style="height: 300px">
                <div class="col-sm-12 table-responsive textcontent">  
                    <?php
                        if (isset($success_message)) {
                        echo "<p class='success'>$success_message</p>";
                        }

                        if (isset($error_message)) {
                        echo "<p class='error'>$error_message</p>";
                        }
                        ?>

                        <?php
                        echo "<script type='text/javascript'>
                        $(document).ready(function(){
                        $('#Modal').modal('show');
                        });
                        </script>";
    
                    if ($result->num_rows > 0) {
                    echo "<table id='table' class='table border-collapse border-secondary table-striped  table-secondary'>
                    <thead class='position-sticky top-0 z-1 table-dark'>
                        <tr>
                            <th class='text-nowrap' scope='col'>Mã Độc Giả</th>
                            <th class='text-nowrap' scope='col'>Họ Và Tên </th>
                            <th class='text-nowrap' scope='col'>Email</th>
                            <th class='text-nowrap' scope='col'>Số Điện Thoại</th>
                        </tr>
                    </thead>
                    <tbody class='overflow-auto'>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['sodienthoai']}</td>
                        </tr>
                    </table> 
            </div>
        </div>
    </div>
</div>";
        }
        echo "</table>";
        } else {
        echo "Không có thông tin độc giả.";
        }
 
        ?>                  
        <?php
        $conn->close();
        ?>
        </div>
    </div>
</section>
</body>
</html>
