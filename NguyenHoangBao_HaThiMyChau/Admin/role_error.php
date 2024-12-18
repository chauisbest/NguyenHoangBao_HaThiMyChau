<script type="text/javascript">
  function Delete(){
    var conf = confirm('Xác nhận xóa!');
    return conf;
  }
</script>
<?php
session_start();
include 'connect.php';
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED& ~E_WARNING);
  include 'include/check_login.php';
?>
<!-- Left side column. contains the logo and sidebar -->
<?php
include 'include/header.php';
include 'include/aside.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     LỖI TRUY CẬP
   </h1>
   <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
    <li><a href="#">Lỗi truy cập </a></li>

  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Lỗi truy cập</h3>
        </div>
        <!-- /.box-header -->
        <?php echo 'Bạn không có quyền truy cập trang này!' ?>
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