<?php
include 'connect.php';
// Bắt đầu phiên làm việc session để duy trì dữ liệu người dùng 
// trong suốt phiên truy cập.
session_start();

// Lấy từ URL
$id_sp = $_GET['id_sp'];

try {
    
    $sql = "SELECT * FROM product
            INNER JOIN manufacturer ON manufacturer.Manufacturer_id = product.Manufacturer_id
            WHERE Product_id = :id_sp";
    // Chuẩn bị câu lệnh SQL để tránh lỗi SQL Injection.
    $stmt = $pdo->prepare($sql);
    // Thực thi câu lệnh SQL và gán giá trị $id_sp vào tham số :id_sp.
    $stmt->execute(['id_sp' => $id_sp]);

    // Lấy một dòng dữ liệu từ kết quả truy vấn dưới dạng mảng kết hợp (key là tên cột của bảng).
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    
    echo "Error: " . $e->getMessage();
}

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
                    <li class="active">Chi tiết sản phẩm</li>
                </ul>    
                <div class="row">      
                    <div id="gallery" class="span3">
                        <!-- LẤY ẢNH ĐT -->
                        <a href="Admin/image_product/<?php echo $row['Anh_sp']; ?>" title="">
                            <img src="Admin/image_product/<?php echo $row['Anh_sp']; ?>" style="width:80%" alt=""/>
                        </a>
                    </div>
                    <div class="span6">
                        <h3><?php echo $row['Ten_sp']; ?></h3>
                        <small></small>
                        <hr class="soft"/>
                        <form class="form-horizontal qtyFrm">
                            <div class="control-group">
                                <!-- LẤY GIÁ -->
                                <label class="control-label"><span><?php echo number_format($row['Gia_sp'], 3, ',', ','); ?> VNĐ</span></label>
                                <div class="controls">
                                    <!-- THÊM VÀO GIỎ HÀNG -->
                                    <a href="addcart.php?id_sp=<?php echo $row['Product_id']; ?>" class="btn btn-large btn-primary pull-right" role="button">Mua hàng <i class="icon-shopping-cart"></i></a>
                                </div>
                            </div>
                        </form>
                        <br class="clr"/>
                        <hr class="soft"/>
                    </div>
                    <div class="span9">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="home">
                                <h4>Chi tiết sản phẩm</h4>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr class="techSpecRow"><td class="techSpecTD1">Hãng sản xuất: </td><td class="techSpecTD2"><?php echo $row['Name_manufacturer']; ?></td></tr>
                                        <tr class="techSpecRow"><td class="techSpecTD1">Bảo hành: </td><td class="techSpecTD2"><?php echo $row['Bao_hanh']; ?></td></tr>
                                        <tr class="techSpecRow"><td class="techSpecTD1">Phụ kiện: </td><td class="techSpecTD2"><?php echo $row['Phu_kien']; ?></td></tr>
                                        <tr class="techSpecRow"><td class="techSpecTD1">Trạng thái: </td><td class="techSpecTD2"><?php echo $row['Trang_thai']; ?></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
