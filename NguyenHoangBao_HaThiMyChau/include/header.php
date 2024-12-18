<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>BaoChau Mobile</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Bootstrap style --> 
	<link id="callCss" rel="stylesheet" href="themes/bootshop/bootstrap.min.css" media="screen"/>
	<link href="themes/css/base.css" rel="stylesheet" media="screen"/>
	<link href="themes/css/bootstrap-responsive.min.css" rel="stylesheet"/>
	<link href="themes/css/font-awesome.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="shortcut icon" href="themes/images/ico/favicon.ico">
	<link rel="stylesheet" href="themes/css/header.css">
	<script src="themes/js/jquery-3.1.1.min.js" type="text/javascript"></script>

</head>
<body>
	<div id="header">
		<div class="container">
			<div id="logoArea" class="navbar">
				<div class="navbar-inner d-flex justify-content-between align-items-center">
					<a class="brand" href="index.php"><img src="themes/images/logo.png" alt="BaoChau Mobile"/></a>
					<!-- TÌM -->
					<form class="form-inline navbar-search" method="post" action="search.php">
						<input id="srchFld1" class="srchTxt" type="text" name="search" placeholder="Tìm kiếm...">
						<button type="submit" id="submitButton" class="btn btn-primary" name="OK">Tìm</button>
					</form>

					<ul id="topMenu" class="nav">
						<a href="login.php">
							<button type="button" class="btn btn-outline-secondary">
								<!-- KIỂM TRA ĐĂNG NHẬP -->
								<?php 
									if(isset($_SESSION['Username'])) echo $_SESSION['Username'];
									else echo "Đăng nhập";
								?>
							</button>
						</a>
						<li><a id="myCart" href="product_summary.php"><img src="themes/images/ico-cart.png" alt="cart"></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
