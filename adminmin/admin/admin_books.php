<?php
session_start();
// admin_books.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QuanLyThuVien";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý thêm sách
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addBook"])) {
    $title = $_POST["input1"];
    $author = $_POST["input2"];
    $bookCode = $_POST["input3"];
    $publishYear = $_POST["input4"];
    $quantity = $_POST["input5"];

    $insertBookSql = "INSERT INTO Sach(TieuDe, TacGia, MaSach, NamXuatBan, SoLuongCon) 
                      VALUES ('$title', '$author', '$bookCode', '$publishYear', '$quantity')";
    if ($conn->query($insertBookSql) === TRUE) {
        // echo "<p class='success'>Sách đã được thêm thành công.</p>";
    } else {
        echo "<p class='error'>Lỗi: " . $conn->error . "</p>";
    }
}

// Xử lý xóa sách
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteBook"])) {
    $bookId = $_POST["bookId"];

    $deleteBookSql = "DELETE FROM Sach WHERE MaSach=$bookId";
    if ($conn->query($deleteBookSql) === TRUE) {
        // echo "<p class='success'>Sách đã được xóa thành công.</p>";
    } else {
        echo "<p class='error'>Lỗi: " . $conn->error . "</p>";
    }
}

// Xử lý sửa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $title = $_POST["input1"];
    $author = $_POST["input2"];
    $bookCode = $_POST["input3"];
    $publishYear = $_POST["input4"];
    $quantity = $_POST["input5"]; 

    $insertBookSql = "UPDATE Sach SET TieuDe = '$title', 
    TacGia = '$author', NamXuatBan = '$publishYear', SoLuongCon = '$quantity'
    WHERE MaSach = '$bookCode'";
    if ($conn->query($insertBookSql) === TRUE) {
    } else {
    }
}



$sql = "SELECT * FROM Sach";
$result_borrowers = $conn->query($sql);

$searchTerm = ''; // Khởi tạo biến lưu trữ giá trị tìm kiếm

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    // Lấy dữ liệu từ form tìm kiếm
    $searchTerm = $_POST['search'];

    // Thực hiện truy vấn dựa trên tên người mượn
    $sql_search = "SELECT * FROM sach WHERE TieuDe LIKE '%$searchTerm%'";

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
    <section class="container-fluid" >
        <div class="row pt-2 ">
            <h2 class="text-center mt-2 ">Quản Lý Sách</h2>
             <!-- Form tìm kiếm -->
        <form method="POST" action="">
            <div class="input-group mb-3" style="width: 50%; margin: auto;">
                <input type="text" class="form-control" placeholder="Nhập tên sách cần tìm" name="search">
                <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search-heart"></i></button>
            </div>
        </form>
        </div>


        <div class="row pt-2"  style="height: 300px">
            <div class="col-sm-12 table-responsive textcontent">  
                <?php
                if ($result_borrowers->num_rows > 0) {
                    echo "<table id='table' class='table border-collapse border-secondary table-striped  table-secondary'>
                    <thead class='position-sticky top-0 z-1 table-dark'>
                        <tr>
                            <th class='text-nowrap' scope='col'>Tiêu Đề</th>
                            <th class='text-nowrap' scope='col'>Tác Giả</th>
                            <th class='text-nowrap' scope='col'>Mã Sách</th>
                            <th class='text-nowrap' scope='col'>Năm Xuất Bản</th>
                            <th class='text-nowrap' scope='col'>Số Lượng Còn</th>
                            <th class='text-nowrap' scope='col'>Thao Tác</th>
                        </tr>
                    </thead>
                <tbody class='overflow-auto'>";
                 while ($row = $result_borrowers->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['TieuDe']}</td>
                            <td>{$row['TacGia']}</td>
                            <td>{$row['MaSach']}</td>
                            <td>{$row['NamXuatBan']}</td>
                            <td>{$row['SoLuongCon']}</td>
                            <td>
                                <form method='post' action=''>
                                    <input type='hidden' name='bookId' value='{$row['MaSach']}'>
                                    <button type='submit' name='deleteBook'>Xóa</button>
                                </form>
                            </td>
                        </tr>";
            }echo "</tbody>
            </table>";
            }
            ?>
        </div>
    </div>

    <div class="row" >
          <div class="col-5 m-auto"><hr size="6px" align="center" color="#000000" /></div>
          <div class="col-2">
            <h2 class="text-center pt-4">
                <span>Thêm Sách</span> 
            </h2>
         </div> 
        <div class="col-5 m-auto"><hr size="6px" align="center" color="#000000"/></div>   
    </div>

    <div class="row bg-darkBlue text-white  " >
        <div class="col-lg-12 text-center ">
           
            <form method="post" class="p-3" action="">
                <label for="title">Tiêu Đề:</label>
                <input type="text" name="input1" placeholder="Tiêu đề sách" required>

                <label for="author">Tác Giả:</label>
                <input type="text" name="input2" placeholder="Tác giả" required>

                <label for="bookCode">Mã Sách:</label>
                <input type="text" name="input3" placeholder="Mã sách" required>

                <label for="publishYear">Năm Xuất Bản:</label>
                <input type="text" name="input4" placeholder="Năm xuất bản" required>

                <label for="quantity">Số Lượng Còn:</label>
                <input type="text" name="input5" placeholder="Số lượng" required>
                <div class="button text-center m-3 ">
                    <button type="submit" name="addBook" class="btn btn-primary me-5 p-2" data-toggle="button" aria-pressed="false" autocomplete="off">Thêm Sách</button>
                    <button type="submit" name="update" class="btn btn-primary  p-2" data-toggle="button" aria-pressed="false" autocomplete="off">Sửa Sách</button>
                </div>
            </form>
            
        </div>
    </div>
    </section>

    <script src="../js/script.js"></script>
</body>
</html>
