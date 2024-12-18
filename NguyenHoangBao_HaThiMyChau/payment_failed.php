<?php
session_start();
include 'connect.php';
?>

<?php
include 'include/header.php';
?>
<div id="mainBody">
	<div class="container">
		<div class="row">

			<div class="span9">
				<ul class="breadcrumb">
					<li><a href="index.php">Trang chủ</a> <span class="divider">/</span></li>
					<li class="active">Thất Bại</li>
				</ul>
				<h1>Thanh toán không thành công!</h1>
                <p>Rất tiếc, giao dịch của bạn đã thất bại. Vui lòng thử lại sau hoặc liên hệ với bộ phận hỗ trợ nếu vấn đề tiếp tục.</p>
                <a href="index.php">Quay lại trang chủ</a>
			</div>						
		</div>    
	</div>
</div>
