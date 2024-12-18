<?php 
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
include 'connect.php';
include 'include/check_login.php';
?>
<?php 
if ($_SESSION['Role'] < 3) {
  header('location: role_error.php');
  exit;
}


$sqlSx = "SELECT * FROM manufacturer";
$stmtSx = $pdo->prepare($sqlSx);
$stmtSx->execute();
$resultSx = $stmtSx->fetchAll();//hien thi ra cho nguoi dung sua nhung field can thiet

if(isset($_GET['id'])){
  $id = $_GET['id'];
  $sql = "SELECT * FROM product WHERE Product_id = :id";//truy van thong tin chi tiet
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row) {
    $Ten_sp = $row['Ten_sp'];
    $Gia_sp = $row['Gia_sp'];
    $Bao_hanh = $row['Bao_hanh'];
    $Phu_kien = $row['Phu_kien'];
    $Trang_thai = $row['Trang_thai'];
    $Tinh_trang = $row['Tinh_trang'];
    $Status = $row['Status'];
    $Manufacturer_id = $row['Manufacturer_id'];
    $Anh_sp = $row['Anh_sp'];
  }
} else {
  header('location: list_product.php');
  exit;
}
//thu thap du lieu tu form
if (isset($_POST['Ten_sp'])) {
  $Ten_sp = $_POST['Ten_sp'];
  $Gia_sp = $_POST['Gia_sp'];
  $Bao_hanh = $_POST['Bao_hanh'];
  $Phu_kien = $_POST['Phu_kien'];
  $Trang_thai = $_POST['Trang_thai'];
  $Tinh_trang = $_POST['Tinh_trang'];
  $Status = $_POST['Status'];
  $Manufacturer_id = $_POST['manufacturer'];

  if ($_FILES['Anh_sp']['name'] == '') {
    $Anh_sp = $_POST['Anh_sp'];//neu nguoi dung ko con anh moi -> tra ve anh cu dc luu tren POST
  } else {
    $Anh_sp = $_FILES['Anh_sp']['name'];
    $Tmp = $_FILES['Anh_sp']['tmp_name'];//tao duong dan tam 
    move_uploaded_file($Tmp, 'image_product/' . $Anh_sp);
  }

  // Prepare and execute update query
  $sqlUpdate = "UPDATE product SET Ten_sp = :Ten_sp, Gia_sp = :Gia_sp, Bao_hanh = :Bao_hanh, Phu_kien = :Phu_kien, 
               Trang_thai = :Trang_thai, Tinh_trang = :Tinh_trang, Status = :Status, 
                Anh_sp = :Anh_sp, Manufacturer_id = :Manufacturer_id WHERE Product_id = :id";
  $stmtUpdate = $pdo->prepare($sqlUpdate);
  $stmtUpdate->bindParam(':Ten_sp', $Ten_sp, PDO::PARAM_STR);
  $stmtUpdate->bindParam(':Gia_sp', $Gia_sp, PDO::PARAM_STR);
  $stmtUpdate->bindParam(':Bao_hanh', $Bao_hanh, PDO::PARAM_STR);
  $stmtUpdate->bindParam(':Phu_kien', $Phu_kien, PDO::PARAM_STR);
  $stmtUpdate->bindParam(':Trang_thai', $Trang_thai, PDO::PARAM_STR);
  $stmtUpdate->bindParam(':Tinh_trang', $Tinh_trang, PDO::PARAM_INT);
  $stmtUpdate->bindParam(':Status', $Status, PDO::PARAM_INT);
  $stmtUpdate->bindParam(':Anh_sp', $Anh_sp, PDO::PARAM_STR);
  $stmtUpdate->bindParam(':Manufacturer_id', $Manufacturer_id, PDO::PARAM_INT);
  $stmtUpdate->bindParam(':id', $id, PDO::PARAM_INT);
  $stmtUpdate->execute();

  // Log the action in the history table
  $session = $_SESSION['Username'];
  $date = time();
  $sql2 = "INSERT INTO history (Username, Action, Timee) VALUES (:username, :action, :time)";
  $stmt2 = $pdo->prepare($sql2);
  $action = "Sửa sản phẩm: $Ten_sp";
  $stmt2->bindParam(':username', $session, PDO::PARAM_STR);
  $stmt2->bindParam(':action', $action, PDO::PARAM_STR);
  $stmt2->bindParam(':time', $date, PDO::PARAM_INT);
  $stmt2->execute();

  // Redirect to the product list page
  header('location: list_product.php');
  exit;
}
?>

<?php include 'include/header.php'; ?>
<?php include 'include/aside.php'; ?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Danh Mục Sản Phẩm</h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
      <li><a href="#">Sửa sản phẩm</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Sửa sản phẩm</h3>
          </div>
          <div class="box-body">
            <form role="form" method="POST" action="product_edit.php?id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="product_name">Tên sản phẩm</label>
                  <input class="form-control" id="product_name" placeholder="Tên sản phẩm" type="text" name="Ten_sp" required="required" value="<?php echo $Ten_sp; ?>">
                </div>

                <div class="form-group">
                  <label>Hãng sản xuất</label>
                  <select name="manufacturer" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <?php foreach ($resultSx as $rowSx) { ?>
                      <option value="<?php echo $rowSx['Manufacturer_id']; ?>" <?php if ($Manufacturer_id == $rowSx['Manufacturer_id']) echo 'selected="selected"'; ?>><?php echo $rowSx['Name_manufacturer']; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputFile">Ảnh đại diện</label>
                  <input id="exampleInputFile" type="file" name="Anh_sp">
                  <input type="hidden" name="Anh_sp" value="<?php echo $Anh_sp; ?>">
                  <img width="100px" max-height="150px" src="image_product/<?php echo $Anh_sp; ?>" />
                  <p class="help-block">Kích thước ảnh là 500x500px sẽ hiển thị đẹp nhất</p>
                </div>

                <div class="form-group">
                  <label for="product_name">Giá sản phẩm</label>
                  <input class="form-control" id="product_name" placeholder="Giá sản phẩm" type="text" name="Gia_sp" required="required" value="<?php echo $Gia_sp; ?>">
                </div>

                <div class="form-group">
                  <label for="product_name">Bảo hành</label>
                  <input class="form-control" id="product_name" placeholder="Bảo hành" type="text" name="Bao_hanh" required="required" value="<?php echo $Bao_hanh; ?>">
                </div>

                <div class="form-group">
                  <label for="product_name">Phụ kiện</label>
                  <input class="form-control" id="product_name" placeholder="Phụ kiện" type="text" name="Phu_kien" required="required" value="<?php echo $Phu_kien; ?>">
                </div>

                <div class="form-group">
                  <label>Tình trạng hàng</label>
                  <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="Tinh_trang">
                    <option value="1" <?php if ($Tinh_trang == 1) echo 'selected="selected"'; ?>>Còn hàng</option>
                    <option value="0" <?php if ($Tinh_trang == 0) echo 'selected="selected"'; ?>>Không còn hàng</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="product_name">Trạng thái hàng</label>
                  <input class="form-control" id="product_name" placeholder="Trạng thái hàng" type="text" name="Trang_thai" required="required" value="<?php echo $Trang_thai; ?>">
                </div>

                <div class="form-group">
                  <label>Trạng thái</label>
                  <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="Status">
                    <option value="1" <?php if ($Status == 1) echo 'selected="selected"'; ?>>Hiển thị</option>
                    <option value="0" <?php if ($Status == 0) echo 'selected="selected"'; ?>>Không hiển thị</option>
                  </select>
                </div>

              </div>
              <div class="box-footer">
                <input type="submit" name="Save" value="Submit" class="btn btn-primary">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include 'include/footer.php'; ?>
