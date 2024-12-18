<script type="text/javascript">
  function Delete(){
    var conf = confirm('Xác nhận xóa');
    return conf;
  }
</script>
<?php
include 'connect.php'; // Make sure this connects using PDO
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
     DANH SÁCH SẢN PHẨM
   </h1>
   <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
    <li><a href="#">Danh sách sản phẩm</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Danh sách sản phẩm</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <a href="product_new.php" role="button" class="btn btn-danger btn-md">Thêm mới Sản Phẩm</a>
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Stt</th>
                <th>Tên sản phẩm</th>
                <th>Giá sản phẩm</th>
                <th>Tên hãng sản xuất</th>
                <th>Ảnh đại diện</th>           
                <th>Trạng thái</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $Stt = 1;

                // Prepare SQL query to get product details using PDO
                $sql = "SELECT Product_id, Ten_sp, Gia_sp, manufacturer.Name_manufacturer, Anh_sp, manufacturer.Status 
                        FROM product
                        INNER JOIN manufacturer ON manufacturer.Manufacturer_id = product.Manufacturer_id
                        ORDER BY Product_id DESC";

                // Prepare and execute query using PDO
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                // Fetching the results
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
              ?>
              <tr>
                <td><?php echo $Stt++; ?></td>                  
                <td><?php echo htmlspecialchars($row['Ten_sp']); ?></td>
                <td><?php echo number_format($row['Gia_sp'], 3); ?></td>
                <td><?php echo htmlspecialchars($row['Name_manufacturer']); ?></td>
                <td><img width="100px" max-height="150px" src="image_product/<?php echo htmlspecialchars($row['Anh_sp']); ?>" /></td>
                <td><?php echo $row['Status'] == 1 ? 'Hiển thị' : 'Không hiển thị'; ?></td>
                <td>
                  <a href="product_edit.php?id=<?php echo $row['Product_id']; ?>">Sửa</a> |  
                  <a onclick="return Delete();" href="product_delete.php?id=<?php echo $row['Product_id']; ?>">Xóa</a>
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
