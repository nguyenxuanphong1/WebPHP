
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php  
@include 'config.php';

session_start();

if(isset($_POST['submit']) ){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);

    $select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);

        if($row['user_type'] == 'admin'){
            $_SESSION['admin_name'] = $row['name'];
            header('location:admin/admin_index.php');

        }elseif($row['user_type'] == 'user'){

            $_SESSION['user_name'] = $row['name'];
            $_SESSION['id'] = $row['id'];
            header('location:user/index.php');
        }

    }else{
        $error[] = 'incorrect email or password!';
    }
};
?>
    <div class="form-container">
        <div class="img-background">
                <img src="./img/truong-dai-hoc-cong-nghe-dong-a-eaut-3.jpg" >
                
        </div>
        <form action="" method="post">
            
            <div >
            <img src="./img/Logo-DH-Cong-Nghe-Dong-A-EAUT.webp" width="100px" >
            <h3>Đăng nhập</h3>
            </div>
            <?php 
            if(isset( $error)){
                foreach( $error as  $error){
                    echo'<span class="error-msg">' .$error. '</span>';
                };
            };
            ?>
            <input type="email" name="email" required placeholder="Email " >
            <input type="password" name="password" required placeholder="Mật khẩu " >
            <input type="submit" name="submit" value="Đăng nhập" class="form-btn">
            <p>Bạn chưa có tài khoản? <a href="registerform.php">Đăng ký?</a></p>
        </form>
    </div>
</body>
</html>



