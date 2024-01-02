
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php  
@include 'config.php';

if(isset($_POST['submit']) ){
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $sdt = mysqli_real_escape_string($conn, $_POST['sodienthoai']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];

    $select = "SELECT * FROM user_form WHERE email = '$email' ";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){
        $error[] = 'user alrealy exist!';
        
    }else{
        if($pass != $cpass){
            $error[] = 'password not matched!';
        }else{
            $insert = "INSERT INTO user_form(id, name, email,sodienthoai, password, user_type) VALUE('$id','$name', '$email','$sdt', '$pass', '$user_type')";
            mysqli_query($conn, $insert);
            header('location:loginform.php');
        }
    }
};
?>

    <section class="form-container">
        <div class="img-background">
            <img src="./img/truong-dai-hoc-cong-nghe-dong-a-eaut-3.jpg" >
        </div>
        <form action="" method="post">
        
       
            <h3>Đăng ký</h3>
            <?php 
            if(isset( $error)){
                foreach( $error as  $error){
                    echo'<span class="error-msg">' .$error. '</span>';
                };
            };
            ?>
            <input type="text" name="id" required placeholder="Mã sinh viên " >
            <input type="text" name="name" required placeholder="Họ và tên " >
            <input type="email" name="email" required placeholder="Email " >
            <input type="tel" name="sodienthoai" required placeholder="Số điện thoại  " >
            <input type="password" name="password" required placeholder="Mật khẩu " >
            <input type="password" name="cpassword" required placeholder="Xác nhận mật khẩu " >
            <select name="user_type">
                <option value="user">user</option>
            </select>
            <input type="submit" name="submit" value="Đăng ký" class="form-btn">
            <p>Bạn đã có tài khoản? <a href="loginform.php">Đăng nhập</a></p>
        </form>
    </section>
</body>
</html>