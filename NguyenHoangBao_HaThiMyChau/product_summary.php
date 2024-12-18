<?php
session_start();
include 'include/header.php';
include 'connect.php';

// PHP sẽ báo cáo tất cả các lỗi nghiêm trọng ngoại trừ:
// Lỗi thông báo nhỏ (E_NOTICE),
// Các cảnh báo không nghiêm trọng (E_WARNING),
// Cảnh báo về tính năng sắp bị loại bỏ (E_DEPRECATED).
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);

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
                        <!-- Số lượng loại hàng trong giỏ -->
                    <?php
                    if(isset($_SESSION['giohang'])){
                        echo count($_SESSION['giohang']);
                    } else {
                        echo 0;
                    }
                    ?>
                    </small>]
                </h3>    
                <hr class="soft"/>

                <?php 
                if(isset($_SESSION['giohang'])){
                    if(isset($_POST['sl'])){
                        foreach($_POST['sl'] as $id_sp => $sl){
                            if($sl == 0){
                                unset($_SESSION['giohang'][$id_sp]);    
                            } else if($sl > 0){
                                $_SESSION['giohang'][$id_sp] = $sl;    
                            }    
                        }        
                    }

                    $arrId = array();
                    foreach($_SESSION['giohang'] as $id_sp => $so_luong){
                        $arrId[] = $id_sp;        
                    }
                    $strId = implode(',', $arrId);

                    try {
                        $sql = "SELECT * FROM product WHERE Product_id IN ($strId) ORDER BY Product_id DESC";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                    } catch (PDOException $e) {
                        echo '<script>
                        alert("Hiện không có sản phẩm nào trong giỏ hàng!");
                    </script>';
                    }
                ?>                    
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Ảnh SP</th>
                            <th>Tên SP</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>

                    <tbody>
                        <form id="giohang" method="post">
                            <?php
                            $totalPriceAll = 0;
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                // $_SESSION['giohang'][$row['Product_id']: SỐ LƯỢNG
                                $totalPrice = $row['Gia_sp'] * $_SESSION['giohang'][$row['Product_id']];
                            ?>    
                            <tr>
                                <td> <img width="60" src="Admin/image_product/<?php echo $row['Anh_sp']; ?>" alt=""/></td>
                                <td><?php echo $row['Ten_sp']; ?></td>
                                <td>
                                    <div class="input-append">
                                        <input class="span1" style="max-width:34px" id="appendedInputButtons" min="0" type="number" name="sl[<?php echo $row['Product_id'];?>]" value="<?php echo $_SESSION['giohang'][$row['Product_id']]; ?>">
                                        <a href="deletecart.php?id_sp=<?php echo $row['Product_id']; ?>" class="btn btn-danger" role="button"><i class="icon-remove icon-white"></i></a>
                                    </div>
                                </td>
                                <td><?php echo number_format($row['Gia_sp'], 3, ',', ','); ?></td>
                                <td><?php echo number_format($totalPrice, 3, ',', ','); ?></td>
                            </tr>
                            <?php
                            // TỔNG TIỀN
                            $totalPriceAll += $totalPrice;
                            }
                            ?>
                        </form>
                    </tbody>
                </table>
                <h3>Tổng giá trị đơn hàng: <span><?php echo number_format($totalPriceAll, 3, ',', ','); ?> VNĐ</span> </h3>
                <?php
                } else {
                    echo '<script>
                        alert("Hiện không có sản phẩm nào trong giỏ hàng!");
                    </script>';
                }
                ?>
                <a href="thanhtoan.php" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a>
                <!-- refresh GIỎ HÀNG -->
                <a href="#" onclick="document.getElementById('giohang').submit();" class="btn btn-large pull-right"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                <a href="deletecart.php?id_sp=0" class="btn btn-danger btn-large pull-right"><i class="icon-remove icon-white"></i></a>                            
            </div>
        </div>
    </div>
</div>
