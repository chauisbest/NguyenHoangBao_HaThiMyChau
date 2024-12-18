<?php
// Báo lỗi trừ các lỗi không quan trọng
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
include 'connect.php';
include 'include/check_login.php';

// Kiểm tra quyền của user
if ($_SESSION['Role'] < 2) {
    header('location: role_error.php');
    exit;
}

if (isset($_POST['Save'])) {
    $username = $_POST['Username'];
    // Hash password using MD5 (Not recommended for production use)
    $password = md5($_POST['Password']); // Mã hóa mật khẩu bằng MD5
    $fullname = $_POST['FullName'];
    $status = $_POST['Status'];
    $role = $_POST['Role']; // Thêm Role vào xử lý

    try {
        // Kiểm tra Username đã tồn tại chưa
        $stmt = $pdo->prepare("SELECT Username FROM admin WHERE Username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            // Chèn dữ liệu vào bảng `admin`
            $stmt = $pdo->prepare("INSERT INTO admin (Username, Password, Role, Status) 
                                   VALUES (:username, :password, :role, :status)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->execute();

            // Ghi lại hành động vào bảng `history`
            $session = $_SESSION['Username'];
            $date = time();
            $action = "Thêm mới Admin: $username";
            $stmt2 = $pdo->prepare("INSERT INTO history (Username, Action, Timee) VALUES (:session, :action, :date)");
            $stmt2->bindParam(':session', $session);
            $stmt2->bindParam(':action', $action);
            $stmt2->bindParam(':date', $date, PDO::PARAM_INT);
            $stmt2->execute();

            // Chuyển hướng
            header('Location: list_user.php');
            exit;
        } else {
            $user_error = "Tên đăng nhập đã tồn tại!";
        }
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
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
    <h1>Thêm mới Admin</h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
      <li class="active">Thêm mới Admin</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Thêm mới Admin</h3>
      </div>
      <div class="box-body">
        <form method="POST" action="">
          <div class="form-group">
            <label>Username<?php if (isset($user_error)) echo '<span style="color:red;">&nbsp;&nbsp;' . $user_error . '</span>'; ?></label>
            <input type="text" name="Username" class="form-control" placeholder="Nhập Username" required>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="Password" class="form-control" placeholder="Nhập mật khẩu" required>
          </div>
          <div class="form-group">
            <label>Role</label>
            <select name="Role" class="form-control" required>
              <option value="1">Editer</option>
              <option value="2" selected>Admin</option>
              <option value="3">Super Admin</option>
            </select>
          </div>
          <div class="form-group">
            <label>Trạng thái</label>
            <select name="Status" class="form-control" required>
              <option value="1" selected>Hiển thị</option>
              <option value="0">Không hiển thị</option>
            </select>
          </div>
          <button type="submit" name="Save" class="btn btn-primary">Lưu</button>
        </form>
      </div>
    </div>
  </section>
</div>

<?php
include 'include/footer.php';
?>
