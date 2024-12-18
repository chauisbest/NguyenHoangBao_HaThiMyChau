<?php
session_start();
include 'connect.php';
include 'include/header.php';
?>
<div id="mainBody">
	<div class="container">
		<div class="row">
			<div class="span9">
				<ul class="breadcrumb">
					<li><a href="index.php">Trang chủ</a> <span class="divider">/</span></li>
					<li class="active">Giỏ hàng</li>
				</ul>
				<h3>GIỎ HÀNG CỦA BẠN 
					[<small>

					<?php
					if(isset($_SESSION['giohang'])){
						echo count($_SESSION['giohang']);
					}else {
						echo 0;
					}
					?>
					</small>]<a href="index.php" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Mua tiếp</a></h3>	
				<hr class="soft"/>
				<?php
				if(isset($_SESSION['giohang'])){
					$arrId = array();
					foreach ($_SESSION['giohang'] as $id_sp => $sl) {
						$arrId[] = $id_sp;
					}
					$strId = implode(',', $arrId);

					// Use a prepared statement to fetch products
					$sql = "SELECT * FROM product WHERE Product_id IN ($strId) ORDER BY Product_id DESC";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
				?>					
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Ảnh SP</th>
							<th>Tên SP</th>
							<th>Giá</th>
							<th>Số lượng</th>
							<th>Tổng tiền</th>
						</tr>
					</thead>
					<tbody>
						<form id="giohang" method="post">
							<?php
							$totalPriceAll = 0;
							while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								$totalPrice = $row['Gia_sp'] * $_SESSION['giohang'][$row['Product_id']];
							?>	
							<tr>
								<td> <img width="60" src="../Admin/image_product/<?php echo $row['Anh_sp']; ?>" alt=""/></td>
								<td><?php echo $row['Ten_sp']; ?></td>
								<td><?php echo number_format($row['Gia_sp'],3,',',','); ?></td>
								<td><?php echo $_SESSION['giohang'][$row['Product_id']]; ?></td>
								<td><?php echo number_format($totalPrice,3,',',','); ?></td>
							</tr>
							<?php
								$totalPriceAll += $totalPrice;
							}
							?>
						</form>
					</tbody>
				</table>
				<h3>Tổng giá trị đơn hàng: <span><?php echo number_format($totalPriceAll,3,',',','); ?>VNĐ</span> </h3>
				<?php
				}
				?>
			<form style="text-align: right;" method="POST" enctype="application/x-www-form-urlencoded">
				<h3>Hình thức thanh toán</h3>
				<select name="payment_method" class="form-control" style="width: 200px; margin-bottom: 10px;">
					<option value="cod">Thanh toán COD</option>
					<option value="redirect">Thanh toán VNPay</option>
				</select>
				<button type="submit" class="btn btn-danger">Thanh toán</button>
			</form>

			<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				if (isset($_POST['payment_method'])) {
					$payment_method = $_POST['payment_method'];

					if ($payment_method == 'cod') {
						header("Location: thanh_toan_cod.php"); // Trang thanh toán COD
						exit();
					} elseif ($payment_method == 'redirect') {
						header("Location: xulythanhtoanVNPay.php"); // Trang xử lý VNPay
						exit();
					}
				}
			}
			?>
			</div>
		</div>
	</div>
</div>

