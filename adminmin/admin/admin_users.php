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

// Xử lý thêm người dùng mới
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addUser"])) {
    $newId = $_POST["input1"];
    $newUsername = $_POST["input2"];
    $newEmail = $_POST["input3"];
    $newsdt = $_POST["input4"];
    $newPassword = md5($_POST["input5"]);
    $newUserType = $_POST["input6"];

    // Thêm người dùng mới vào cơ sở dữ liệu
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $insertUserSql = "INSERT INTO user_form (id, name, email, sodienthoai, password, user_type) 
                      VALUES ('$newId', '$newUsername', '$newEmail','$newsdt', '$newPassword', '$newUserType')";

    if ($conn->query($insertUserSql) === TRUE) {
        $success_message = "Người dùng đã được thêm thành công.";
    } else {
        $error_message = "Lỗi: " . $conn->error;
        // Thêm dòng sau để hiển thị thông báo lỗi từ MySQL
        echo "Error: " . mysqli_error($conn);
    }

}

// Xử lý xóa người dùng
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteUser"])) {
    $userIdToDelete = $_POST["userIdToDelete"];

    $deleteUserSql = "DELETE FROM user_form WHERE id=$userIdToDelete";
    
    if ($conn->query($deleteUserSql) === TRUE) {
        $success_message = "Người dùng đã được xóa thành công.";
    } else {
        $error_message = "Lỗi: " . $conn->error;
    }
}

// Xử lý sửa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $newId = $_POST["input1"];
    $newUsername = $_POST["input2"];
    $newEmail = $_POST["input3"];
    $newsdt = $_POST["input4"];
    $newPassword = $_POST["input5"];
    $newUserType = $_POST["input6"];

    $insertBookSql = "UPDATE user_form SET 
    Name = '$newUsername', Email = '$newEmail', sodienthoai = '$newsdt' , Password = '$newPassword', user_type = '$newUserType'
    WHERE Id = '$newId'";
    if ($conn->query($insertBookSql) === TRUE) {
    } else {
    }
}

// Lấy danh sách người dùng từ cơ sở dữ liệu
$sql = "SELECT * FROM user_form";
$result_borrowers = $conn->query($sql);

$searchTerm = ''; // Khởi tạo biến lưu trữ giá trị tìm kiếm

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    // Lấy dữ liệu từ form tìm kiếm
    $searchTerm = $_POST['search'];

    // Thực hiện truy vấn dựa trên tên người mượn
    $sql_search = "SELECT * FROM user_form WHERE name LIKE '%$searchTerm%'";

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="user.css">
    <link rel="stylesheet" href="./snow.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>Quản Trị Viên - Quản Lý Người Dùng</title>
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

    <div class="">
        <header class="header-banner text-center h-20vh ">
            <img width="20%" src="../img/banner_left.png">
        </header>

    <nav>
        <ul>
            <li><a href="admin_books.php" class="text-center">Quản Lý Sách</a></li>
            <!-- <li><a href="admin_readers.php">Quản Lý Độc Giả</a></li> -->
            <li><a href="admin_borrowings.php">Quản Lý Mượn/Trả Sách</a></li>
            <li><a href="admin_users.php">Quản Lý Độc Giả</a></li>
            <li><a href="admin_report.php">Báo Cáo</a></li>
            <li><a href="" id="logout">Đăng Xuất</a></li>
            <!-- Thêm liên kết hoặc nút để điều hướng đến các trang khác -->
        </ul>
    </nav>
    </div>
    <section class="container-fluid ">
        <div class="row pt-2 ">
            <h2 class="text-center mt-2">Quản Lý Người Dùng</h2>
        </div>
        <form method="POST" action="">
            <div class="input-group mb-3" style="width: 50%; margin: auto;">
                <input type="text" class="form-control" placeholder="Nhập tên cần tìm" name="search">
                <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search-heart"></i></button>
            </div>
        </form>
        <div class="row pt-2"  style="height: 300px">
            <div class="col-sm-12 table-responsive textcontent">  

        <?php
        if ($result_borrowers->num_rows > 0) {
            echo "<table id = 'table' class='table border-collapse border-secondary table-striped  table-secondary'>
                <thead class='position-sticky top-0 z-1 table-dark'>
                    <tr>
                        <th scope='col'>Id</th>
                        <th scope='col'>Name</th>
                        <th scope='col'>Email</th>
                        <th scope='col'>Số điện thoại</th>
                        <th scope='col'>Password</th>
                        <th scope='col'>Quyền</th>
                        <th scope='col'></th>
                    </tr>
                </thead>

            <tbody class='overflow-auto'>";
            while ($row = $result_borrowers->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['sodienthoai']}</td>
                        <td>{$row['password']}</td>
                        <td>{$row['user_type']}</td>
                        <td>
                            <form method='post' action=''>
                                <input type='hidden' name='userIdToDelete' value='{$row['id']}'>
                                <button type='submit' name='deleteUser'>Xóa</button>
                            </form>
                        </td>
                    </tr>";
            }
            echo "</tbody>
            </table>";
        } else {
            echo "<p>Không có người dùng nào.</p>";
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
                <span>Thêm Người Dùng Mới</span> 
            </h2>
         </div> 
        <div class="col-4 m-auto"><hr size="6px" align="center" color="#000000"/></div>   
    </div>

    <div class="row bg-darkBlue text-white" >
        <div class="col-sm-12 ">
        <form method="post" class="text-center p-3" action="">
            <label for="newUsername">Id:</label>
            <input type="text" name="input1" placeholder="Id" required>

            <label for="newUsername">Name:</label>
            <input type="text" name="input2" placeholder="Name" required>

            <label for="newUsername">Email:</label>
            <input type="text" name="input3" placeholder="Email" required>

            <label for="newUsername">Số điện thoại:</label>
            <input type="text" name="input4" placeholder="Số điện thoại" required>

            <label for="newPassword">Mật Khẩu:</label>
            <input type="password" name="input5" placeholder="Mật khẩu" required>

            <label for="newUserType">Loại Người Dùng:</label>
            <select name="input6" required>
                <option value="user">user</option>
                <option value="admin">admin</option>
            </select>


            <div class="button text-center m-3 ">
                    <button type="submit" name="addUser" class="btn btn-primary me-5 p-2" data-toggle="button" aria-pressed="false" autocomplete="off">Thêm Người Dùng</button>
                    <button type="submit" name="update" class="btn btn-primary  p-2" data-toggle="button" aria-pressed="false" autocomplete="off">Sửa Người Dùng</button>
                </div>
        </form>
        </div>
    </div>
    </section>
    <script src="../js/script.js"></script>
</body>
</html>
