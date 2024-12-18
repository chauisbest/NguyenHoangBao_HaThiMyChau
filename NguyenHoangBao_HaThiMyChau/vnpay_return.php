<?php
session_start();
include 'connect.php';

// Cấu hình VNPay
$vnp_HashSecret = "C0Q52E27NNPQYTAS8R0J7DPT51ISMWMO";

// Lấy dữ liệu trả về từ VNPay
$vnp_SecureHash = $_GET['vnp_SecureHash'];
$inputData = [];
foreach ($_GET as $key => $value) {
    if ($key != "vnp_SecureHash") {
        $inputData[$key] = $value;
    }
}
ksort($inputData);
$query = "";
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}
$secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

// Kiểm tra tính toàn vẹn dữ liệu
if ($secureHash == $vnp_SecureHash) {
    if ($_GET['vnp_ResponseCode'] == '00') { // Thanh toán thành công
        try {
            // Kiểm tra người dùng đã đăng nhập hay chưa
            if (!isset($_SESSION['Username'])) {
                echo "<script>alert('Vui lòng đăng nhập để đặt hàng!'); window.location.href = 'login.php';</script>";
                exit();
            }
        
            $username = $_SESSION['Username']; // Lấy username khách hàng từ session
            var_dump($username);
        
            // Lấy thông tin người dùng
            $stmt = $pdo->prepare("SELECT * FROM users WHERE Username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if (!$user) {
                throw new Exception("Không tìm thấy thông tin người dùng.");
            }
            $customerId = $user['ID']; 
            var_dump($customerId);
        
            // Kiểm tra giỏ hàng
            if (!isset($_SESSION['giohang']) || empty($_SESSION['giohang'])) {
                echo "<script>alert('Giỏ hàng trống!'); window.location.href = 'cart.php';</script>";
                exit();
            }
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $time = date("Y-m-d H:i:s");
            $totalPriceAll = 0;
        
            // Tạo mảng tham số để tránh SQL Injection
            $placeholders = implode(',', array_fill(0, count($_SESSION['giohang']), '?'));
            $productIds = array_keys($_SESSION['giohang']);
        
            // Lấy danh sách sản phẩm từ giỏ hàng
            $stmt = $pdo->prepare("SELECT * FROM product WHERE Product_id IN ($placeholders)");
            $stmt->execute($productIds);
        
            // Tính tổng giá trị đơn hàng
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $productId = $row['Product_id'];
                $quantity = $_SESSION['giohang'][$productId];
                $totalPriceAll += $row['Gia_sp'] * $quantity;
            }
        
            // Lưu thông tin đơn hàng vào bảng `orderproduct`
            $stmtOrder = $pdo->prepare("INSERT INTO orderproduct (Customer_id, Timee, PriceAll, Status)
                                        VALUES (?, ?, ?, 'Processing')");
            $stmtOrder->execute([$customerId, $time, $totalPriceAll]);
        
            // Lấy ID của đơn hàng vừa tạo
            $orderId = $pdo->lastInsertId();
            var_dump($orderId);
        
            // Lưu chi tiết đơn hàng vào bảng `orderdetail`
            $stmt2 = $pdo->prepare("SELECT * FROM product WHERE Product_id IN ($placeholders)");
            $stmt2->execute($productIds);
        
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $productId = $row2['Product_id'];
                $quantity = $_SESSION['giohang'][$productId];
                $price = $row2['Gia_sp'];
        
                $stmtOrderDetail = $pdo->prepare("INSERT INTO orderdetail (Order_id, Product_id, Price, Quantity)
                                                VALUES (?, ?, ?, ?)");
                $stmtOrderDetail->execute([$orderId, $productId, $price, $quantity]);
            }
        
            // Xóa giỏ hàng
            unset($_SESSION['giohang']);
        
            // Chuyển đến trang hoàn thành
            header("Location: hoanthanh.php");
            exit();
        
        } catch (PDOException $e) {
            echo "Lỗi khi xử lý thanh toán: " . $e->getMessage();
            exit();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            exit();
        }
    } else {
        // Thanh toán thất bại
        header("Location: thatbai.php");
        exit();
    }
} else {
    echo "Dữ liệu không hợp lệ!";
    exit();
}
?>
