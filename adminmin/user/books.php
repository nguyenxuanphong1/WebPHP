<?php
// books.php
session_start();
// Kết nối đến cơ sở dữ liệu (thay thế thông tin kết nối thực tế của bạn)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QuanLyThuVien";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}



// ... (các phần code khác của bạn)

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["muon"])) {
    $maDocGia = $_SESSION['id'];
    $ngayMuon = date("Y-m-d H:i:s");
    $maSach = $_POST["id"];

    // Thực hiện thêm dữ liệu vào bảng muontrasach
    $sql_insert = "INSERT INTO muontrasach(MaDocGia, MaSach, NgayMuon, NgayTra) VALUES ('$maDocGia', '$maSach', '$ngayMuon', NULL)";
    
    if ($conn->query($sql_insert) === TRUE) {
        // Nếu thêm thành công, cập nhật số lượng sách còn lại trong bảng Sach
        $sql_update = "UPDATE Sach SET SoLuongCon = SoLuongCon - 1 WHERE MaSach = '$maSach'";
        if ($conn->query($sql_update) === TRUE) {
            // Số lượng sách đã được cập nhật thành công
            // echo "Mượn sách thành công";
        } else {
            echo "Lỗi khi cập nhật số lượng sách: " . $conn->error;
        }
    } else {
        echo "Lỗi khi mượn sách: " . $conn->error;
    }
}

// ... (phần code HTML và hiển thị danh sách sách)





// Truy vấn cơ sở dữ liệu để lấy thông tin sách
$sql = "SELECT * FROM Sach";
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
    <link rel="stylesheet" href="snow.css">
    <link rel="stylesheet" href="http://pajasevi.github.io/CSSnowflakes/">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>Quản Lý Thư Viện - Thông Tin Sách</title>
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

    <div class="container-fluid">
       <div class="row">
            <header class="header-banner text-center h-20vh ">
                <img width="25%" src="../img/banner_left.png">
            </header>
       </div>
    </div>
    <section class="container-fluid ">
        <div class="row bg-darkBlue toolbar ">
            <div class="col-sm-3 "><a href="books.php" class="text-nav ">Sách</a></div>
            <div class="col-sm-3 "><a href="readers.php" class="text-nav ">Độc Giả</a></div>
            <div class="col-sm-3 "><a href="historybook.php" class="text-nav ">Lịch Sử Mượn Sách</a></div>
            <div class="col-sm-3 "><a href="introducepage.php" class="text-nav " id="gt">Giới thiệu</a></div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row" style="height: 800px">
            <div class="col-sm-2 text-black img-user">
                <div class="img-userpage"><img src="../img/userpage.png " alt=""></div>
                <h5><span>user</span></h5>
                <h5> <i class="bi bi-person-hearts"></i> <span><?php echo $_SESSION['user_name']?>-<?php echo $_SESSION['id']?></span></h5>
            
                <a href=""  id="logout">Đăng Xuất<i class="bi bi-door-open"></i></a>
            </div>
            <div class="col-sm-10  text-dark">
                <div class="row">
                    <h3 class="text-center ">Danh sách</h3>
                </div>
            
                <div class="row pt-2" style="height: 300px">
                        <div class="col-sm-12 table-responsive textcontent">
                            <?php
                            if ($result->num_rows > 0) {
                                echo "<table id='table' class='table border-collapse border-secondary table-striped table-secondary'>
                                <thead class='position-sticky top-0 z-1 table-dark'>
                                    <tr>
                                        <th class='text-nowrap' scope='col'>Tiêu Đề</th>
                                        <th class='text-nowrap' scope='col'>Tác Giả</th>
                                        <th class='text-nowrap' scope='col'>Mã Số Sách</th>
                                        <th class='text-nowrap' scope='col'>Năm Xuất Bản</th>
                                        <th class='text-nowrap' scope='col'>Số Lượng Còn</th>
                                        <th class='text-nowrap' scope='col'>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody class='overflow-auto'>";

                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr class='text-dark'>
                                        <td>{$row['TieuDe']}</td>
                                        <td>{$row['TacGia']}</td>
                                        <td>{$row['MaSach']}</td>
                                        <td>{$row['NamXuatBan']}</td>
                                        <td>{$row['SoLuongCon']}</td>
                                        <td>
                                            <form method='post'>
                                                <input type='hidden' name='id' value='{$row['MaSach']}'>
                                                <input name='muon' class='btn btn-primary' type='submit' value='Mượn'>
                                            </form>
                                        </td>
                                    </tr>";
                                }

                                echo "</tbody></table>";
                            } else {
                                echo "Không có sách.";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
        <script src="../js/script.js"></script>
</body>

</html>
