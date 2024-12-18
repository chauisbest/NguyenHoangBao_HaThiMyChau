<script type="text/javascript">
  function Delete(){
    return confirm('Xác nhận xóa!');
  }
</script>
<?php
include 'connect.php';
include 'include/check_login.php';

// Role validation
if($_SESSION['Role'] <= 2){
  header('location: role_error.php');
  exit();
}
?>
<?php
include 'include/header.php';
include 'include/aside.php';
?>
<div class="content-wrapper">
  <!-- Page Header -->
  <section class="content-header">
    <h1>DANH SÁCH NGƯỜI DÙNG</h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
      <li class="active">Danh sách người dùng</li>
    </ol>
  </section>

  <!-- Main Content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Danh sách người dùng</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <a href="customer_new.php" role="button" class="btn btn-danger btn-md">Thêm mới người dùng</a>
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>STT</th>
                  <th>Tên tài khoản</th>
                  <th>Email</th>
                  <th>Họ và tên</th>
                  <th>Vai trò</th>
                  <th>Trạng thái</th>
                  <th>Ngày tạo</th>
                  <th>Hành động</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $stt = 1;
                // Truy vấn dữ liệu từ bảng users
                $sql = "SELECT ID, Username, Email, FullName, Role, Status, CreatedAt FROM users ORDER BY ID DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($users) > 0) {
                  foreach ($users as $row) {
                    ?>
                    <tr>
                      <td><?php echo $stt++; ?></td>
                      <td><?php echo htmlspecialchars($row['Username']); ?></td>
                      <td><?php echo htmlspecialchars($row['Email']); ?></td>
                      <td><?php echo htmlspecialchars($row['FullName']); ?></td>
                      <td><?php echo htmlspecialchars($row['Role']); ?></td>
                      <td><?php echo ($row['Status'] == 'active') ? 'Hoạt động' : 'Không hoạt động'; ?></td>
                      <td><?php echo date('d/m/Y H:i', strtotime($row['CreatedAt'])); ?></td>
                      <td>
                        <a href="customer_edit.php?id=<?php echo $row['ID']; ?>">Sửa</a> |  
                        <a onclick="return Delete();" href="customer_delete.php?id=<?php echo $row['ID']; ?>">Xóa</a>
                      </td>
                    </tr>
                    <?php
                  }
                } else {
                  echo "<tr><td colspan='8' class='text-center'>Không có dữ liệu người dùng.</td></tr>";
                }
                ?>
              </tbody>
            </table>
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
