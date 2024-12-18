<?php
// Kết nối cơ sở dữ liệu
include 'connect.php'; 


// Bắt đầu session để truy cập thông tin người dùng
session_start();

// Bật hiển thị lỗi để phục vụ giai đoạn phát triển và debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Kiểm tra tham số ID từ URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid ID provided'); // Dừng script nếu ID không hợp lệ
}

$id = $_GET['id']; // Lấy ID người dùng từ tham số GET

// 2. Truy vấn thông tin người dùng từ cơ sở dữ liệu
$sql = "SELECT * FROM users WHERE ID = :id";
$stmt = $pdo->prepare($sql); 
$stmt->execute(['id' => $id]); 

// Kiểm tra xem người dùng có tồn tại không
if ($stmt->rowCount() === 0) {
    die('No user found with the given ID.');
}

// Lấy thông tin người dùng từ kết quả truy vấn
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$username = $row['Username'];   
$email = $row['Email'];         
$fullname = $row['FullName'];
$password = $row['Password'];   
$status = $row['Status'];      

// 3. Xử lý khi người dùng gửi form cập nhật thông tin
if (isset($_POST['Save'])) {
    // Lấy dữ liệu từ form
    $username = $_POST['Username'];
    $email = $_POST['Email'];
    $fullname = $_POST['FullName'];
    $status = $_POST['Status'];
    $new_password = $_POST['Password']; 

    // Kiểm tra nếu mật khẩu mới được nhập, thì mã hóa mật khẩu
    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Mã hóa mật khẩu mới
    } else {
        $hashed_password = $row['Password']; // Giữ nguyên mật khẩu cũ nếu không thay đổi
    }

    // Cập nhật thông tin người dùng trong cơ sở dữ liệu
    $sql = "UPDATE users 
            SET Username = :username, Email = :email, FullName = :fullname, Password = :password, Status = :status 
            WHERE ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'fullname' => $fullname,
        'password' => $hashed_password, // Lưu mật khẩu (mã hóa nếu thay đổi)
        'status' => $status,
        'id' => $id
    ]);

    // 4. Ghi lại lịch sử hành động vào bảng history
    $session = $_SESSION['Username'] ?? 'Unknown User'; // Lấy tên người dùng từ session
    $date = time(); // Thời gian thực hiện (Unix timestamp)
    $sql2 = "INSERT INTO history (Username, Action, Timee) 
             VALUES (:session, :action, :date)";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([
        'session' => $session,                   
        'action' => "Sửa thông tin người dùng: $username", 
        'date' => $date                       
    ]);

    // Chuyển hướng về trang danh sách người dùng sau khi cập nhật xong
    header('location: list_customer.php');
    exit(); // Dừng script
}
?>
<?php
include 'include/header.php';
?>
<!-- Left side column. contains the logo and sidebar -->
<?php
include 'include/aside.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>SỬA THÔNG TIN NGƯỜI DÙNG</h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="#">Sửa người dùng</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Sửa thông tin người dùng</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form role="form" method="POST" action="">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="username">Tên đăng nhập</label>
                                    <input class="form-control" id="username" placeholder="Tên đăng nhập" type="text" name="Username" value="<?php echo htmlspecialchars($username); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" id="email" placeholder="Email" type="email" name="Email" value="<?php echo htmlspecialchars($email); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="fullname">Tên đầy đủ</label>
                                    <input class="form-control" id="fullname" placeholder="Tên đầy đủ" type="text" name="FullName" value="<?php echo htmlspecialchars($fullname); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="password">Mật khẩu mới</label>
                                    <input class="form-control" id="password" placeholder="Nhập mật khẩu mới" type="password" name="Password">
                                </div>
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select class="form-control" name="Status" required>
                                        <option value="1" <?php if ($status == 1) echo 'selected'; ?>>Hiển thị</option>
                                        <option value="0" <?php if ($status == 0) echo 'selected'; ?>>Không hiển thị</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" name="Save" class="btn btn-primary">Lưu</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
