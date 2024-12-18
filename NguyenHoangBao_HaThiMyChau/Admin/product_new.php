<?php 
  session_start();
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
  include 'connect.php';
  include 'include/check_login.php';
?>

<?php 
  // Fetch product categories
  // $sqlDm = "SELECT * FROM catalog WHERE Parent_id > 0";
  // $stmtDm = $pdo->prepare($sqlDm);
  // $stmtDm->execute();
  // $resultDm = $stmtDm->fetchAll();

  // Fetch manufacturers
  $sqlSx = "SELECT * FROM manufacturer";
  $stmtSx = $pdo->prepare($sqlSx);
  $stmtSx->execute();
  $resultSx = $stmtSx->fetchAll();

  // Add product functionality
  if (isset($_POST['Save'])) {
    $Ten_sp = $_POST['Ten_sp'];
    $Gia_sp = $_POST['Gia_sp'];
    $Bao_hanh = $_POST['Bao_hanh'];
    $Phu_kien = $_POST['Phu_kien'];
    $Trang_thai = $_POST['Trang_thai'];
    $Tinh_trang = $_POST['Tinh_trang'];
    $Manufacturer_id = $_POST['manufacturer'];
    $Status = $_POST['Status'];
    $Anh_sp = $_FILES['Anh_sp']['name'];
    $Tmp = $_FILES['Anh_sp']['tmp_name'];

    // Check if product already exists
    $sqlCheck = "SELECT * FROM product WHERE Ten_sp = :Ten_sp";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(':Ten_sp', $Ten_sp, PDO::PARAM_STR);
    $stmtCheck->execute();
                                          
    if ($stmtCheck->rowCount() == 0) {
      // Move uploaded file to the target directory
      move_uploaded_file($Tmp, 'image_product/' . $Anh_sp);

      // Insert new product
      $sqlInsert = "INSERT INTO product (Ten_sp, Gia_sp, Bao_hanh, Phu_kien, Trang_thai, Tinh_trang, Status, Anh_sp, Manufacturer_id) 
                    VALUES (:Ten_sp, :Gia_sp, :Bao_hanh, :Phu_kien,:Trang_thai, :Tinh_trang, :Status, :Anh_sp, :Manufacturer_id)";
      $stmtInsert = $pdo->prepare($sqlInsert);
      $stmtInsert->bindParam(':Ten_sp', $Ten_sp, PDO::PARAM_STR);
      $stmtInsert->bindParam(':Gia_sp', $Gia_sp, PDO::PARAM_STR);
      $stmtInsert->bindParam(':Bao_hanh', $Bao_hanh, PDO::PARAM_STR);
      $stmtInsert->bindParam(':Phu_kien', $Phu_kien, PDO::PARAM_STR);
      $stmtInsert->bindParam(':Trang_thai', $Trang_thai, PDO::PARAM_STR);
      $stmtInsert->bindParam(':Tinh_trang', $Tinh_trang, PDO::PARAM_INT);
      $stmtInsert->bindParam(':Status', $Status, PDO::PARAM_INT);
      $stmtInsert->bindParam(':Anh_sp', $Anh_sp, PDO::PARAM_STR);
      $stmtInsert->bindParam(':Manufacturer_id', $Manufacturer_id, PDO::PARAM_INT);
      $stmtInsert->execute();

      // Log the action in the history table
      $session = $_SESSION['Username'];
      $date = time();
      $sqlHistory = "INSERT INTO history (Username, Action, Timee) VALUES (:Username, :Action, :Timee)";
      $stmtHistory = $pdo->prepare($sqlHistory);
      $action = "Thêm mới sản phẩm: $Ten_sp";
      $stmtHistory->bindParam(':Username', $session, PDO::PARAM_STR);
      $stmtHistory->bindParam(':Action', $action, PDO::PARAM_STR);
      $stmtHistory->bindParam(':Timee', $date, PDO::PARAM_INT);
      $stmtHistory->execute();

      // Redirect to product list page
      header('Location: list_product.php');
      exit;
    } else {
      $product_error = "Tên sản phẩm đã tồn tại";
    }
  }
?>

<?php include 'include/header.php'; ?>
<?php include 'include/aside.php'; ?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Danh Mục Sản Phẩm</h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
      <li><a href="#">Danh mục sản phẩm</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Thêm mới sản phẩm</h3>
          </div>
          <div class="box-body">
            <form role="form" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="product_name">Tên sản phẩm 
                    <?php if (isset($product_error)) echo '<span style="color: red;">&nbsp;&nbsp;' . $product_error . '</span>'; ?>
                  </label>
                  <input class="form-control" id="product_name" placeholder="Tên sản phẩm" type="text" name="Ten_sp" required value="<?php if (isset($Ten_sp)) echo htmlspecialchars($Ten_sp); ?>">
                </div>

                <div class="form-group">
                  <label>Hãng sản xuất</label>
                  <select name="manufacturer" class="form-control select2" style="width: 100%;" required>
                    <?php foreach ($resultSx as $rowSx) { ?>
                      <option value="<?php echo $rowSx['Manufacturer_id']; ?>"><?php echo $rowSx['Name_manufacturer']; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputFile">Ảnh đại diện</label>
                  <input id="exampleInputFile" type="file" name="Anh_sp">
                  <p class="help-block">Kích thước ảnh là 500x500px sẽ hiển thị đẹp nhất</p>
                </div>

                <div class="form-group">
                  <label for="product_name">Giá sản phẩm</label>
                  <input class="form-control" id="product_name" placeholder="Giá sản phẩm" type="text" name="Gia_sp" required value="<?php if (isset($Gia_sp)) echo htmlspecialchars($Gia_sp); ?>">
                </div>

                <div class="form-group">
                  <label for="product_name">Bảo hành</label>
                  <input class="form-control" id="product_name" placeholder="Bảo hành" type="text" name="Bao_hanh" required value="<?php if (isset($Bao_hanh)) echo htmlspecialchars($Bao_hanh); ?>">
                </div>

                <div class="form-group">
                  <label for="product_name">Phụ kiện</label>
                  <input class="form-control" id="product_name" placeholder="Phụ kiện" type="text" name="Phu_kien" required value="<?php if (isset($Phu_kien)) echo htmlspecialchars($Phu_kien); ?>">
                </div>

                <div class="form-group">
                  <label>Tình trạng hàng</label>
                  <select class="form-control select2" style="width: 100%;" name="Tinh_trang" required>
                    <option value="1" <?php if (isset($Tinh_trang) && $Tinh_trang == 1) echo 'selected'; ?>>Còn hàng</option>
                    <option value="0" <?php if (isset($Tinh_trang) && $Tinh_trang == 0) echo 'selected'; ?>>Không còn hàng</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="product_name">Trạng thái hàng</label>
                  <input class="form-control" id="product_name" placeholder="Trạng thái hàng" type="text" name="Trang_thai" required value="<?php if (isset($Trang_thai)) echo htmlspecialchars($Trang_thai); ?>">
                </div>

                <div class="form-group">
                  <label>Trạng thái</label>
                  <select class="form-control select2" style="width: 100%;" name="Status" required>
                    <option value="1" <?php if (isset($Status) && $Status == 1) echo 'selected'; ?>>Hiển thị</option>
                    <option value="0" <?php if (isset($Status) && $Status == 0) echo 'selected'; ?>>Không hiển thị</option>
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
