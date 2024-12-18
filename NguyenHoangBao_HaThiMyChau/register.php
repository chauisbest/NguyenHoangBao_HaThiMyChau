<?php
include 'connect.php'; // Kết nối cơ sở dữ liệu

// Bật lỗi để debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['Register'])) {
    // Lấy dữ liệu từ form
    $username = trim($_POST['Username']);
    $password = trim($_POST['Password']);
    $confirmPassword = trim($_POST['ConfirmPassword']);
    $email = trim($_POST['Email']);
    $fullname = trim($_POST['FullName']);

    // Kiểm tra xem dữ liệu có rỗng không
    if (empty($username) || empty($password) || empty($confirmPassword) || empty($email)) {
        $register_error = "Please fill out all fields.";
    } 
    // Kiểm tra Confirm Password
    elseif ($password !== $confirmPassword) {
        $register_error = "Passwords do not match!";
    } 
    // Kiểm tra độ mạnh của mật khẩu
    elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $register_error = "Password must be at least 8 characters long, include uppercase, lowercase, numbers, and special characters.";
    } 
    else {
        // Kiểm tra xem tên người dùng đã tồn tại hay chưa
        $check_sql = "SELECT * FROM users WHERE Username = :username";
        $stmt = $pdo->prepare($check_sql);
        $stmt->execute(['username' => $username]);

        if ($stmt->rowCount() > 0) { // Nếu tên người dùng đã tồn tại
            $register_error = "Username already exists!";
        } else {
            // Hash mật khẩu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Thêm người dùng mới vào cơ sở dữ liệu
            $insert_sql = "INSERT INTO users (Username, Password, Email, FullName, Role) VALUES (:username, :password, :email, :fullname, 'user')";
            $stmt = $pdo->prepare($insert_sql);
            $stmt->execute([
                'username' => $username,
                'password' => $hashed_password,
                'email' => $email,
                'fullname' => $fullname
            ]);

            // Chuyển hướng sang trang đăng nhập
            header('Location: login.php');
            exit();
        }
    }
}
?>


<?php 
include 'login_css.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signin_css.php">
    <title>Register</title>
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <?php if (isset($register_error)): ?>
            <p style="color: red;"><?php echo $register_error; ?></p>
        <?php endif; ?>
        <form method="POST" class="form">
            <input type="text" name="Username" class="input" placeholder="Username" required>
            <input type="password" name="Password" class="input" placeholder="Password" required>
            <input type="password" name="ConfirmPassword" class="input" placeholder="Confirm Password" required>
            <input type="email" name="Email" class="input" placeholder="Email" required>
            <input type="text" name="FullName" class="input" placeholder="Full Name" required>
            <button type="submit" class="form-btn" name="Register">Register</button>
        </form>

        <p class="sign-up-label">
            Already have an account? <span class="sign-up-link"><a href="login.php">Log in</a></span>
        </p>
    </div>
</body>
</html>
