<?php
include 'connect.php';
include 'include/check_login.php';

// Ensure the user has the correct role
if ($_SESSION['Role'] < 3) {
    header('location: role_error.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Using prepared statement to prevent SQL injection
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE User_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the user details
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $username = $row['Username'];
            $role = $row['Role'];
            $status = $row['Status'];
        } else {
            header('location: list_user.php');
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header('location: list_user.php');
    exit;
}

if (isset($_POST['save'])) {
    $username = $_POST['Username'];
    $role = $_POST['Role'];
    $status = $_POST['Status'];

    // Handle password update if provided
    if (!empty($_POST['Password'])) {
        // Hash password using MD5 (Not recommended for production)
        $password = md5($_POST['Password']);
    } else {
        $password = null; // Keep the password unchanged if not provided
    }

    try {
        // Update user data using prepared statement
        if ($password) {
            // Update with password change
            $stmt = $pdo->prepare("UPDATE admin SET Username = :username, Password = :password, Role = :role, Status = :status WHERE User_id = :id");
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        } else {
            // Update without changing password
            $stmt = $pdo->prepare("UPDATE admin SET Username = :username, Role = :role, Status = :status WHERE User_id = :id");
        }
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Log the action in the history table
        $session = $_SESSION['Username'];
        $date = time();
        $action = "Sửa User: $username";
        $stmt2 = $pdo->prepare("INSERT INTO history(Username, Action, Timee) VALUES (:session, :action, :date)");
        $stmt2->bindParam(':session', $session, PDO::PARAM_STR);
        $stmt2->bindParam(':action', $action, PDO::PARAM_STR);
        $stmt2->bindParam(':date', $date, PDO::PARAM_INT);
        $stmt2->execute();

        // Redirect after saving
        header('Location: list_user.php');
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php include 'include/header.php'; ?>

<!-- Left side column. contains the logo and sidebar -->
<?php include 'include/aside.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Sửa thành viên</h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
      <li><a href="#">Sửa thành viên</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Sửa Admin</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <form role="form" method="post" action="user_edit.php?id=<?php echo $_GET['id']; ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="username">Username <?php if (isset($user_error)) { echo $user_error; } ?></label>
                  <input class="form-control" id="username" placeholder="Username" type="text" name="Username" value="<?php echo $username; ?>" readonly>
                </div>

                <div class="form-group">
                  <label for="password">Mật khẩu</label>
                  <input class="form-control" id="password" placeholder="Nhập mật khẩu mới (nếu muốn thay đổi)" type="password" name="Password">
                </div>

                <div class="form-group">
                  <?php
                    // Fetch roles using PDO
                    $stmt_role = $pdo->prepare("SELECT * FROM role");
                    $stmt_role->execute();
                  ?>
                  <label>Phân Quyền</label>
                  <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="Role">
                    <?php
                    while ($rowRole = $stmt_role->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <option <?php if (isset($role) && $role == $rowRole['Role_id']) { echo 'selected = "selected"'; } ?> value="<?php echo $rowRole['Role_id'];?>"><?php echo $rowRole['Name_role']; ?></option>
                    <?php 
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Trạng thái</label>
                  <select name="Status" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option <?php if ($status == 1) echo 'selected="selected"'; ?> value="1">Hiển thị</option>
                    <option <?php if ($status == 0) echo 'selected="selected"'; ?> value="0">Không hiển thị</option>
                  </select>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" name="save" value="Lưu" class="btn btn-primary">
              </div>
            </form>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include 'include/footer.php'; ?>
