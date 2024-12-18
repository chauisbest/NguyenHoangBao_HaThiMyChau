<?php
ob_start();
session_start();
include 'connect.php';
?>
<?php
include 'include/header.php';
?>

<div id="mainBody">
  <div class="container">
      <div class="span12">
        <h4>Kết quả tìm kiếm</h4>
        <ul class="thumbnails">
          <?php
          if (isset($_POST['OK'])) {
            $search = $_POST['search'];

            if (empty($search)) {
              // echo "Yêu cầu nhập dữ liệu vào ô trống";
              $sql = "SELECT * FROM product ";
              $stmt = $pdo->prepare($sql);
              $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                  <li class="span3">
                    <div class="thumbnail" style="width: auto; height: 445px">
                      <a href="product_details.php"><img src="Admin/image_product/<?php echo $row['Anh_sp']; ?>" alt=""></a>
                      <div class="caption">
                        <h5><?php echo $row['Ten_sp']; ?></h5>
                        <h4 style="text-align:center">
                          <a class="btn" href="product_details.php?id_sp=<?php echo $row['Product_id']; ?>"> <i class="icon-zoom-in"></i></a>
                          <a class="btn" href="addcart.php?id_sp=<?php echo $row['Product_id']; ?>"> Mua hàng <i class="icon-shopping-cart"></i></a> 
                          <a class="btn btn-primary" href="#"><?php echo number_format($row['Gia_sp'], 3, ',', ','); ?></a>
                        </h4>
                      </div>
                    </div>
                  </li>
                  <?php
              }
            } else {
              $sql = "SELECT * FROM product WHERE Ten_sp LIKE :search ORDER BY Product_id DESC";
              $stmt = $pdo->prepare($sql);
              $search_term = "%$search%";
              // PDO::PARAM_STR: chỉ định kiểu dữ liệu của tham số là chuỗi.
              $stmt->bindParam(':search', $search_term, PDO::PARAM_STR);
              $stmt->execute();

              // Trả về số lượng dòng kết quả từ câu truy vấn SQL.
              $num = $stmt->rowCount();

              if ($num > 0 && $search != "") {
                ?>
                <p>&nbsp; <?php echo "$num kết quả trả về với từ khóa: <b>$search</b>"; ?> </p>
                <?php
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                  <li class="span3">
                    <div class="thumbnail" style="width: auto; height: 445px">
                      <a href="product_details.php"><img src="Admin/image_product/<?php echo $row['Anh_sp']; ?>" alt=""></a>
                      <div class="caption">
                        <h5><?php echo $row['Ten_sp']; ?></h5>
                        <h4 style="text-align:center">
                          <a class="btn" href="product_details.php?id_sp=<?php echo $row['Product_id']; ?>"> <i class="icon-zoom-in"></i></a>
                          <a class="btn" href="addcart.php?id_sp=<?php echo $row['Product_id']; ?>"> Mua hàng <i class="icon-shopping-cart"></i></a> 
                          <a class="btn btn-primary" href="#"><?php echo number_format($row['Gia_sp'], 3, ',', ','); ?></a>
                        </h4>
                      </div>
                    </div>
                  </li>
                  <?php
                }
              } else {
                echo "Không tìm thấy kết quả";
              }
            }
          }
          ?>
        </ul>
    </div>
  </div>
</div>