<?php

function get_Price($id, $pdo) {
    try {
        $sql = "SELECT Gia_sp FROM product WHERE Product_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        // Lấy một dòng dữ liệu từ kết quả truy vấn dưới dạng mảng kết hợp (key là tên cột của bảng).
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $gia = $row['Gia_sp'];
            return $gia;
        }
        return 0; 
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return 0;
    }
}

function totalPrice($pdo) {
    $cart = $_SESSION['giohang'];
    $tong = 0;
    foreach ($cart as $key => $value) {
        $gia = get_Price($key, $pdo); 
        $tong_sp = $gia * $value;
        $tong = $tong + $tong_sp;
    }
    return $tong;
}

?>
