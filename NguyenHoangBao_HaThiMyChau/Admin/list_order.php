<script type="text/javascript">
  // Xác nhận xóa đơn hàng
  function Delete() {
    return confirm('Xác nhận xóa đơn hàng này?');
  }
</script>

<?php
include 'connect.php';
include 'include/check_login.php';
include 'include/header.php';
include 'include/aside.php';
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Page Header -->
  <section class="content-header">
    <h1>DANH SÁCH ĐƠN HÀNG</h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
      <li class="active">Danh sách đơn hàng</li>
    </ol>
  </section>

  <!-- Main Content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Danh sách đơn hàng</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <?php 
            // Truy vấn SQL kết hợp bảng orderproduct và users
            $sql = "SELECT 
                        orderproduct.Order_id,
                        users.Username,
                        users.Email,
                        users.FullName,
                        orderproduct.Timee,
                        orderproduct.PriceAll,
                        CASE 
                            WHEN orderproduct.Status = 1 THEN 'Đã xử lý'
                            ELSE 'Chưa xử lý'
                        END AS OrderStatus
                    FROM 
                        orderproduct
                    INNER JOIN 
                        users ON orderproduct.Customer_id = users.ID
                    ORDER BY 
                        orderproduct.Timee DESC";

            // Thực thi câu lệnh SQL
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            // Kiểm tra nếu có dữ liệu
            if ($stmt->rowCount() > 0) {
            ?>
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>Tên tài khoản</th>
                    <th>Email</th>
                    <th>Họ và tên</th>
                    <th>Thời gian</th>
                    <th>Tổng tiền hóa đơn</th>
                    <th>Trạng thái</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                    // Đặt múi giờ về Việt Nam (UTC+7)
                    date_default_timezone_set('Asia/Ho_Chi_Minh');

                    $Stt = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // Xử lý thời gian, tránh lỗi nếu NULL
                        $formattedTime = $row['Timee'] 
                            ? date("d/m/Y h:i A", strtotime($row['Timee'])) 
                            : "Không xác định";

                        // Định dạng lại số tiền
                        $formattedPrice = number_format($row['PriceAll']*1000, 0, ',', '.');
                ?>

                  <tr>
                    <td><?php echo $Stt++; ?></td>                  
                    <td><?php echo htmlspecialchars($row['Username']); ?></td>
                    <td><?php echo htmlspecialchars($row['Email']); ?></td>
                    <td><?php echo htmlspecialchars($row['FullName']); ?></td>
                    <td><?php echo $formattedTime; ?></td>
                    <td><?php echo $formattedPrice; ?> VNĐ</td>             
                    <td><?php echo $row['OrderStatus']; ?></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            <?php 
            } else {
              echo "<p>Không có đơn hàng nào được tìm thấy.</p>";
            }
            ?>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>
  </section>
</div>

<?php
include 'include/footer.php';
?>
