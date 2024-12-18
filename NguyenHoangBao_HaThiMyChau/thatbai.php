<?php
session_start();
include 'connect.php';
?>

<!-- Header End====================================================================== -->
<?php
include 'include/header.php';
?>
<div id="mainBody">
	<div class="container">
		<div class="row">

			<!-- Sidebar end=============================================== -->
			<div class="span9">
				<ul class="breadcrumb">
					<li><a href="index.php">Trang chủ</a> <span class="divider">/</span></li>
					<li class="active">Thanh toán thất bại</li>
				</ul>
				<h3>THANH TOÁN THẤT BẠI
					<a href="index.php" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Quay về trang chủ</a></h3>	
					<hr class="soft"/>
					<div class="prd-block"> 
						<div class="ordered">
							<p class="ordered-report">Thanh toán của Quý khách đã thất bại!</p>
							<p>• Vui lòng kiểm tra lại thông tin thanh toán của Quý khách hoặc thử lại sau.</p>
							<p>• Nếu Quý khách gặp khó khăn, xin vui lòng liên hệ với bộ phận hỗ trợ khách hàng của chúng tôi qua Email hoặc Số Điện thoại.</p>
							<p>• Chúng tôi xin lỗi vì sự bất tiện này và hy vọng sẽ phục vụ Quý khách trong lần mua hàng tới.</p>
							<p align="center">Cám ơn Quý khách đã sử dụng Sản phẩm của Công ty chúng Tôi!</p>
						</div>						
					</div>    
				</div>
			</div></div>
		</div>
		<!-- MainBody End ============================= -->
