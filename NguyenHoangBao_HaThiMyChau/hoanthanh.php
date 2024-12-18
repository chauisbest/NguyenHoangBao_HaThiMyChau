<?php
session_start();
include 'connect.php';
?>

<?php include 'include/header.php'; ?>
<div id="mainBody">
    <div class="container">
        <div class="row">
            <div class="span9">
                <ul class="breadcrumb">
                    <li><a href="index.php">Trang chủ</a> <span class="divider">/</span></li>
                    <li class="active">Hoàn thành</li>
                </ul>
                <h3>MUA HÀNG THÀNH CÔNG
                    <a href="index.php" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Quay về trang chủ</a></h3>    
                    <hr class="soft"/>
                    <div class="prd-block"> 
                        <div class="ordered">
                            <p class="ordered-report">Quý khách đã đặt hàng thành công!</p>
                            <p>• Hóa đơn mua hàng của Quý khách đã được chuyển đến Địa chỉ Email có trong phần Thông tin Khách hàng của chúng Tôi</p>
                            <p>• Sản phẩm của Quý khách sẽ được chuyển đến Địa chỉ có trong phần Thông tin Khách hàng của chúng Tôi sau thời gian 2 đến 3 ngày, tính từ thời điểm này.</p>
                            <p>• Nhân viên giao hàng sẽ liên hệ với Quý khách qua Số Điện thoại trước khi giao hàng 24 tiếng</p>
                            <p align="center">Cám ơn Quý khách đã sử dụng Sản phẩm của Công ty chúng Tôi!</p>
                        </div>                         
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
