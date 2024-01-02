<?php
// manage_borrow_return.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QuanLyThuVien";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

session_start();


// Xử lý khi người dùng gửi biểu mẫu để cập nhật thông tin mượn/trả sách
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateTransaction"])) {
    $transactionId = $_POST["transactionId"];
    $returnDate = $_POST["returnDate"];

    // Chỉ cho phép admin cập nhật ngày mượn
    if ($userRole == 'admin') {
        $borrowDate = $_POST["borrowDate"];
        $updateTransactionSql = "UPDATE MuonTraSach SET NgayMuon='$borrowDate', NgayTra='$returnDate' WHERE MaMuonTra=$transactionId";
    } else {
        $updateTransactionSql = "UPDATE MuonTraSach SET NgayTra='$returnDate' WHERE MaMuonTra=$transactionId";
    }

    if ($conn->query($updateTransactionSql) === TRUE) {
        $success_message = "Thông tin mượn/trả sách đã được cập nhật thành công.";
    } else {
        $error_message = "Lỗi: " . $conn->error;
    }
}

// Truy vấn thông tin mượn/trả sách
$sql = "SELECT MuonTraSach.MaMuonTra, DocGia.HoTenDem, DocGia.Ten, Sach.TieuDe, MuonTraSach.NgayMuon, MuonTraSach.NgayTra
        FROM MuonTraSach
        INNER JOIN DocGia ON MuonTraSach.MaDocGia = DocGia.MaDocGia
        INNER JOIN Sach ON MuonTraSach.MaSach = Sach.MaSach";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Quản Lý Thư Viện - Thông Tin Mượn/Trả Sách</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="user.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
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
        <div class="row pt-2" style="height: 1100px">
            <div class="col-sm-2 text-black img-user">
                <div class="img-userpage"><img src="../img/userpage.png " alt=""></div>
                <h5><span>user</span></h5>
                <h5> <i class="bi bi-person-hearts"></i> <span><?php echo $_SESSION['user_name']?></span></h5>

                <a href="../loginform.php" class="btn">Thoát <i class="bi bi-door-open"></i></a>
            </div>
            <div class="col-sm-10 bg-success text-white">
                <div class="row">
                    <h3 class="text-center "> Thông Tin Mượn/Trả Sách</h3>
                </div>
            </div>
        </div>        
    </section>

    
    <?php
    if (isset($success_message)) {
        echo "<p class='success'>$success_message</p>";
    }

    if (isset($error_message)) {
        echo "<p class='error'>$error_message</p>";
    }
    ?>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Mã Mượn/Trả</th>
                    <th>Họ Tên Độc Giả</th>
                    <th>Tiêu Đề Sách</th>";

        echo "<th>Ngày Trả</th>
                    <th>Chỉnh Sửa</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['MaMuonTra']}</td>
                    <td>{$row['HoTenDem']} {$row['Ten']}</td>
                    <td>{$row['TieuDe']}</td>";

            echo "<td>{$row['NgayTra']}</td>
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='transactionId' value='{$row['MaMuonTra']}'>";
            echo "<label for='returnDate'>Ngày Trả:</label>
                    <input type='date' name='returnDate' value='{$row['NgayTra']}' required>
                    
                    <button type='submit' name='updateTransaction'>Cập Nhật</button>
                </form>
            </td>
        </tr>";
        }

        echo "</table>";
    } else {
        echo "Không có thông tin mượn/trả sách.";
    }
    ?>

    <footer>
        <!-- Thêm nội dung chân trang nếu cần -->
    </footer>
</body>
</html>
