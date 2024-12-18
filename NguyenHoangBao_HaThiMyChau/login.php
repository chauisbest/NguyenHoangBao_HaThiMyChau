<?php
include 'connect.php'; // Kết nối cơ sở dữ liệu
session_start();

// Kiểm tra nếu người dùng đã nhấn nút đăng nhập
if (isset($_POST['Login'])) {
    // Lấy dữ liệu người dùng nhập vào
    // loại bỏ các thẻ HTML và PHP khỏi một chuỗi
    $username = strip_tags($_POST["Username"]);
    $password = $_POST["Password"];

  // Chuẩn bị truy vấn để lấy thông tin người dùng từ bảng 'users'
  $sql = "SELECT * FROM users WHERE Username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

  // Kiểm tra mật khẩu
  // Nếu tìm thấy tài khoản với username cung cấp
    if ($row) {
        if (password_verify($password, $row['Password'])) {
            $valid = true;
        } elseif (md5($password) === $row['Password']) {
            $valid = true;
            $new_hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql_update = "UPDATE users SET Password = :password WHERE Username = :username";
            $update_stmt = $pdo->prepare($sql_update);
            $update_stmt->execute([
                'password' => $new_hashed_password,
                'username' => $username
            ]);
        } else {
            $valid = false;
        }

        if ($valid) {
            // Successful login 
            $_SESSION['Username'] = $row['Username'];
            $_SESSION['Role'] = $row['Role'];
            header('location: index.php');
            exit;
        } else {
            $login_error = "Tên đăng nhập hoặc mật khẩu không đúng!";
        }
    }
}

?>

<?php 
include 'login_css.php'; // Đưa vào file CSS để thiết kế trang
?>

<div class="form-container">
    <p class="title">Welcome Back</p>
    <?php if (isset($login_error)): ?>
        <p class="error-message" style="color: red;"><?php echo $login_error; ?></p>
    <?php endif; ?>
    <form class="form" method="POST">
        <input type="text" class="input" name="Username" placeholder="Username" required>
        <input type="password" class="input" name="Password" placeholder="Password" required>
        <button type="submit" class="form-btn" name="Login">Log in</button>
    </form>

    <p class="sign-up-label">
        Don't have an account? <span class="sign-up-link"><a href="register.php">Sign up</a></span>
    </p>

    <div class="buttons-container">
        <div class="google-login-button">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" x="0px" y="0px" class="google-icon" viewBox="0 0 48 48" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12 c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24 c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657 C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36 c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571 c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
            </svg>
            <span>Log in with Google</span>
        </div>
    </div>
</div>
