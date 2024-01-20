<?php
session_start();
// admin_report.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QuanLyThuVien";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Thống kê thông tin người mượn sách
$sql_borrowers = "SELECT user_form.name, user_form.sodienthoai, sach.TieuDe, muontrasach.NgayMuon
                FROM muontrasach 
                INNER JOIN user_form ON muontrasach.MaDocGia = user_form.id 
                INNER JOIN sach ON muontrasach.MaSach = sach.MaSach
                GROUP BY muontrasach.MaDocGia";
$result_borrowers = $conn->query($sql_borrowers);


$searchTerm = ''; // Khởi tạo biến lưu trữ giá trị tìm kiếm

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    // Lấy dữ liệu từ form tìm kiếm
    $searchTerm = $_POST['search'];

    // Thực hiện truy vấn dựa trên tên người mượn
    $sql_search = "SELECT user_form.name, user_form.sodienthoai, sach.TieuDe, muontrasach.NgayMuon
                    FROM muontrasach 
                    INNER JOIN user_form ON muontrasach.MaDocGia = user_form.id  
                    INNER JOIN sach ON muontrasach.MaSach = sach.MaSach
                    WHERE user_form.name LIKE '%$searchTerm%' 
                    GROUP BY muontrasach.MaDocGia";

    $result_borrowers = $conn->query($sql_search);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./snow.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>Quản Trị Viên - Quản Lý Sách</title>
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
    
    <div class="">
        <header class="header-banner text-center h-20vh ">
            <img width="20%" src="../img/banner_left.png">
        </header>
        <nav>
            <ul>
                <li><a href="admin_books.php">Quản Lý Sách</a></li>
                <li><a href="admin_borrowings.php">Quản Lý Mượn/Trả Sách</a></li>
                <li><a href="admin_users.php">Quản Lý Độc Giả</a></li>
                <li><a href="admin_report.php">Báo Cáo</a></li>
                <li><a href="" id="logout">Đăng Xuất</a></li>
            </ul>
        </nav>
    </div>
    <section>
        <div class="text-center pt-2">
            <h2 class="text-center mt-2 ">Thống kê Báo Cáo <i class="bi bi-flag"></i></h2>
            <!-- Form tìm kiếm -->
    <form method="POST" action="">
        <div class="input-group mb-3" style="width: 50%; margin: auto;">
            <input type="text" class="form-control" placeholder="Nhập tên người cần tìm" name="search">
            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search-heart"></i></button>
        </div>
    </form>

<!-- Hiển thị kết quả -->
<div class="row pt-2" style="height: 300px">
    <div class="col-sm-12 table-responsive textcontent">
        <?php
        // Hiển thị thông tin người mượn sách
        if ($result_borrowers->num_rows > 0) {
            echo "<table id='table' class='table border-collapse border-secondary table-striped table-secondary'>
                <thead class='position-sticky top-0 z-1 table-dark'>
                    <tr>
                        <th class='text-nowrap' scope='col'>Tên</th>
                        <th class='text-nowrap' scope='col'>Số Điện Thoại</th>
                        <th class='text-nowrap' scope='col'>Tên Sách</th>
                        <th class='text-nowrap' scope='col'>Ngày Mượn</th>
                    </tr>
                </thead>
                <tbody class='overflow-auto'>";
            while ($row = $result_borrowers->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['sodienthoai']}</td>
                        <td>{$row['TieuDe']}</td>
                        <td>{$row['NgayMuon']}</td>
                    </tr>";
            }
            echo "</tbody></table>";
        }
        ?>
    </div>
</div>


        </div>

        
    </section>

    <script src="../js/script.js"></script>
</body>
</html>
