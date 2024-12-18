<script type="text/javascript">
  function Delete(){
    var conf = confirm('Xác nhận xóa!');
    return conf;
  }
</script>
<?php
include 'connect.php';
include 'include/check_login.php';

if($_SESSION['Role'] != 3){
  header('location: role_error.php');
}
?>
<?php
include 'include/header.php';
include 'include/aside.php';
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
     DANH SÁCH ADMIN
   </h1>
   <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
    <li><a href="#">Danh sách Admin </a></li>

  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Danh sách admin</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <a href="user_new.php" role="button" class="btn btn-danger btn-md">Thêm mới Admin</a>
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Stt</th>
                <th>User name</th>
                <th>Phân quyền</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                $stt = 1;

                // Use PDO to fetch users from the admin table
                $sql = "SELECT * FROM admin ORDER BY User_id DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                // Loop through results and display them
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                      <td><?php echo $stt++; ?></td>

                      <td><?php echo htmlspecialchars($row['Username']); ?></td>
                      <td><?php 
                          $role = $row['Role'];
                          if($role == 1) echo "Editor"; 
                          elseif($role == 2) echo "Admin"; 
                          else echo "Super Admin"; 
                      ?></td>
                      <td><?php 
                        $status = $row['Status'];
                        echo $status == 1 ? 'Hiển thị' : 'Không hiển thị';
                      ?></td>
                      <td>
                        <a href="user_edit.php?id=<?php echo $row['User_id']; ?>" >Sửa</a> |  
                        <a onclick="return Delete();" href="user_delete.php?id=<?php echo $row['User_id']; ?>" >Xóa</a>
                      </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
include 'include/footer.php';
?>
