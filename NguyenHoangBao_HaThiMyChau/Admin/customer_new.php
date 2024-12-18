<?php
// Kết nối cơ sở dữ liệu
include 'connect.php';
session_start(); // Bắt đầu phiên làm việc

// Hiển thị lỗi để debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Xử lý form khi nhấn nút "Save"
if (isset($_POST['SAVE'])) {
    // Lấy dữ liệu từ form
    $username = trim($_POST['Username']);   
    $password = trim($_POST['Password']);   
    $email = trim($_POST['Email']);         
    $fullname = trim($_POST['FullName']);    
    $role = $_POST['Role'];                
    $status = $_POST['Status'];              

    // Biến lưu lỗi
    $errors = [];

    // 2. Kiểm tra các trường không được để trống
    if (empty($username)) {
        $errors[] = "Tên đăng nhập không được để trống.";
    }
    if (empty($password)) {
        $errors[] = "Mật khẩu không được để trống.";
    }
    if (empty($email)) {
        $errors[] = "Email không được để trống.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Kiểm tra định dạng email
        $errors[] = "Email không hợp lệ.";
    }
    if (empty($fullname)) {
        $errors[] = "Tên đầy đủ không được để trống.";
    }

    // 3. Nếu không có lỗi, kiểm tra tên đăng nhập đã tồn tại chưa
    if (empty($errors)) {
        $sql = "SELECT * FROM users WHERE Username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);

        if ($stmt->rowCount() == 0) {
            // 4. Nếu người dùng chưa tồn tại, thực hiện thêm mới
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Mã hóa mật khẩu

            $sql = "INSERT INTO users (Username, Password, Email, FullName, Role, Status) 
                    VALUES (:username, :password, :email, :fullname, :role, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'username' => $username,
                'password' => $hashed_password,
                'email' => $email,
                'fullname' => $fullname,
                'role' => $role,
                'status' => $status
            ]);

            // 5. Ghi lại lịch sử vào bảng history
            $session = $_SESSION['Username'] ?? 'Unknown User';
            $date = time();
            $sql2 = "INSERT INTO history (Username, Action, Timee) 
                     VALUES (:session, :action, :date)";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute([
                'session' => $session,
                'action' => "Thêm mới Người dùng: $username",
                'date' => $date
            ]);

            // 6. Chuyển hướng sau khi thêm thành công
            header('location: list_customer.php');
            exit();
        } else {
            $errors[] = "Tên đăng nhập đã tồn tại.";
        }
    }
}
?>

<?php
include 'include/header.php';
include 'include/aside.php';
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>THÊM NGƯỜI DÙNG</h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li class="active">Thêm người dùng</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Thêm người dùng</h3>
                    </div>
                    <div class="box-body">
                        <form role="form" method="POST" action="">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="username">Tên đăng nhập</label>
                                    <input class="form-control" id="username" placeholder="Tên đăng nhập" type="text" name="Username" value="<?php echo htmlspecialchars($username ?? '', ENT_QUOTES); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Mật khẩu</label>
                                    <input class="form-control" id="password" placeholder="Mật khẩu" type="password" name="Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" id="email" placeholder="Email" type="email" name="Email" value="<?php echo htmlspecialchars($email ?? '', ENT_QUOTES); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="fullname">Tên đầy đủ</label>
                                    <input class="form-control" id="fullname" placeholder="Tên đầy đủ" type="text" name="FullName" value="<?php echo htmlspecialchars($fullname ?? '', ENT_QUOTES); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="role">Quyền</label>
                                    <select class="form-control" id="role" name="Role">
                                        <option value="user" <?php echo (isset($role) && $role == 'user') ? 'selected' : ''; ?>>User</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <select class="form-control" id="status" name="Status" required>
                                        <option value="1" <?php echo (isset($status) && $status == 1) ? 'selected' : ''; ?>>Hiển thị</option>
                                        <option value="0" <?php echo (isset($status) && $status == 0) ? 'selected' : ''; ?>>Không hiển thị</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Hiển thị lỗi -->
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php foreach ($errors as $error): ?>
                                            <li><?php echo htmlspecialchars($error, ENT_QUOTES); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <div class="box-footer">
                                <input type="submit" name="SAVE" value="Submit" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
