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

// Xử lý thêm mới giao dịch mượn sách
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["borrowBook"])) {
    $readerId = $_POST["readerId"];
    $bookId = $_POST["bookId"];
    $borrowDate = $_POST["borrowDate"];

    $insertBorrowSql = "INSERT INTO MuonTraSach (MaDocGia, MaSach, NgayMuon) 
                        VALUES ('$readerId', '$bookId', '$borrowDate')";

    if ($conn->query($insertBorrowSql) === TRUE) {
        $success_message = "Giao dịch mượn sách đã được thêm thành công.";
    } else {
        $error_message = "Lỗi: " . $conn->error;
    }
}

// Xử lý cập nhật giao dịch trả sách
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["returnBook"])) {
    $transactionId = $_POST["transactionId"];
    $returnDate = $_POST["returnDate"];

    $updateReturnSql = "UPDATE MuonTraSach SET NgayTra='$returnDate' WHERE MaMuonTra=$transactionId";

    if ($conn->query($updateReturnSql) === TRUE) {
        $success_message = "Giao dịch trả sách đã được cập nhật thành công.";
    } else {
        $error_message = "Lỗi: " . $conn->error;
    }
}

// Lấy danh sách mượn/trả sách từ cơ sở dữ liệu
$sql = "SELECT MuonTraSach.MaMuonTra, MuonTraSach.MaSach, 
MuonTraSach.NgayMuon, MuonTraSach.NgayTra, docgia.Ten
FROM MuonTraSach join docgia on MuonTraSach.MaDocGia = docgia.MaDocGia ";
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>Quản Trị Viên - Quản Lý Mượn/Trả Sách</title>
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
            <li><a id="logout" href="admin_index.php?logout=true" >Đăng Xuất</a></li>
            <!-- Thêm các liên kết khác tùy thuộc vào nhu cầu -->
        </ul>
    </nav>
    </div>

</div>
    <section class="container-fluid">
        <div class="row pt-2 ">
            <h2 class="text-center mt-2">Quản Lý Mượn/Trả Sách</h2>
        </div>

        <div class="row pt-2"  style="height: 300px">
            <div class="col-sm-12 table-responsive textcontent">  

            

            <?php
            echo "<script type='text/javascript'>
            $(document).ready(function(){
            $('#Modal').modal('show');
            });
            </script>";

        
        
        

            if ($result->num_rows > 0) {
                echo "<table class='table border-collapse border-secondary table-striped  table-secondary'>
                    <thead class='position-sticky top-0 z-1 table-dark'>
                        <tr>
                            <th class='text-nowrap' scope='col'>Mã mượn trả</th>
                            <th class='text-nowrap' scope='col'>Độc Giả</th>
                            <th class='text-nowrap' scope='col'>Mã sách</th>
                            <th class='text-nowrap' scope='col'>Ngày Mượn</th>
                            <th class='text-nowrap' scope='col'>Ngày Trả</th>
                            <th class='text-nowrap' scope='col'>Thao Tác</th>
                        </tr>
                    </thead>
                <tbody class='overflow-auto'>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['MaMuonTra']}</td>
                            <td>{$row['Ten']}</td>
                            <td>{$row['MaSach']}</td>
                            <td>{$row['NgayMuon']}</td>
                            <td>{$row['NgayTra']}</td>
                            <td>
                                <form method='post' action=''>
                                    <input type='hidden' name='transactionId' value='{$row['MaMuonTra']}'>
                                    <label for='returnDate'>Ngày Trả:</label>
                                    <input type='date' name='returnDate' required>
                                    <button type='submit' name='returnBook' class='buttonborrowings'>Cập Nhật Trả Sách</button>
                                </form>
                            </td>
                        </tr>";
            } echo "</tbody>
            </table>";
            } else {
                echo "<p>Không có giao dịch mượn/trả sách nào.</p>";
            }

            if (isset($success_message)) {
                echo "<p class='success'>$success_message</p>";
            }

            if (isset($error_message)) {
                echo "<p class='error'>$error_message</p>";
            }
            ?>
            </div>
        </div>
            

        <div class="row" >
            <div class="col-4 m-auto"><hr size="6px" align="center" color="#000000" /></div>
            <div class="col-4">
                <h2 class="text-center pt-4">
                    <span>Thêm Mới Giao Dịch Mượn Sách</span> 
                </h2>
            </div> 
            <div class="col-4 m-auto"><hr size="6px" align="center" color="#000000"/></div>
        </div>

        <div class="row bg-info">
            <div class="col-sm-12 ">
                <form method="post" class="text-center p-3" action="">
                    <label for="readerId">Chọn Độc Giả:</label>
                    <select name="readerId" required>
                    <!-- Lấy danh sách độc giả từ cơ sở dữ liệu và tạo các tùy chọn -->
                    <?php
                    $readerQuery = "SELECT * FROM DocGia";
                    $readerResult = $conn->query($readerQuery);

                    if ($readerResult->num_rows > 0) {
                    while ($readerRow = $readerResult->fetch_assoc()) {
                        echo "<option value='{$readerRow['MaDocGia']}'> {$readerRow['Ten']}</option>";
                        }
                    }
                    ?>
                    </select>

                    <label for="bookId">Chọn Sách:</label>
                    <select name="bookId" required>
                        <!-- Lấy danh sách sách từ cơ sở dữ liệu và tạo các tùy chọn -->
                        <?php
                        $bookQuery = "SELECT * FROM Sach WHERE SoLuongCon > 0";
                        $bookResult = $conn->query($bookQuery);

                        if ($bookResult->num_rows > 0) {
                            while ($bookRow = $bookResult->fetch_assoc()) {
                                echo "<option value='{$bookRow['MaSach']}'>{$bookRow['TieuDe']}</option>";
                            }
                        }
                        ?>
                    </select>

                    <label for="borrowDate">Ngày Mượn:</label>
                    <input type="date" name="borrowDate" required>
                    <div >
                        <button class="btn btn-primary mt-3  p-2" data-toggle="button" aria-pressed="false" autocomplete="off" type="submit" name="borrowBook">Thêm Giao Dịch Mượn Sách</button>
                    </div>
                </form>
            </div>
    </div>
    </section>
    <script src="../js/script.js"></script>
</body>
</body>
</html>
