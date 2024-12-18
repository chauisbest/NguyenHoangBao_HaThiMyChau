<?php
    ob_start();
    session_start();
    include 'connect.php';
?>
<?php
    include 'include/header.php';
?> 
<div id="mainBody" style="width: 100%; margin: 0 auto; text-align: center;">
    <div class="container" style="margin: 0 auto; width: 90%;"> <!-- Adjust width if needed -->
        <div class="row">
            <!-- Nội dung chính -->
            <div class="span12">
                <div class="center">
                    <h1 style="text-align: center;">Danh sách sản phẩm</h1>
                    <ul class="thumbnails">
                    <?php 
                        try {
                            // Truy vấn để lấy tất cả sản phẩm
                            $sql = "SELECT * FROM product ORDER BY Product_id DESC";
                            $stmt = $pdo->query($sql);

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <li class="span3">
                            <div class="thumbnail" style="width: auto; height: 445px">
                                <a href="product_details.php?id_sp=<?php echo $row['Product_id']; ?>">
                                    <img src="Admin/image_product/<?php echo htmlspecialchars($row['Anh_sp']); ?>" alt="">
                                </a>
                                <div class="caption">
                                    <h5><?php echo htmlspecialchars($row['Ten_sp']); ?></h5>
                                    <h4 style="text-align:center">
                                        <a class="btn" href="product_details.php?id_sp=<?php echo $row['Product_id']; ?>">
                                            <i class="icon-zoom-in"></i>
                                        </a> 
                                        <a class="btn" href="addcart.php?id_sp=<?php echo $row['Product_id']; ?>">
                                            Mua hàng <i class="icon-shopping-cart"></i>
                                        </a> 
                                        <a class="btn btn-primary" href="addcart.php?id_sp=<?php echo $row['Product_id']; ?>">
                                            <?php echo number_format($row['Gia_sp'], 3, ',', ','); ?>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        </li>
                    <?php
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                    ?>            
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
