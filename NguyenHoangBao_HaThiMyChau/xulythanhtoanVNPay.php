<?php
session_start();
include 'connect.php';

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Kiểm tra người dùng đã đăng nhập
if (!isset($_SESSION['Username'])) {
    echo "<script>alert('Vui lòng đăng nhập để đặt hàng!'); window.location.href = 'login.php';</script>";
    exit();
}

// Lấy tổng giá trị đơn hàng từ giỏ hàng
$totalPriceAll = 0;
if (isset($_SESSION['giohang']) && !empty($_SESSION['giohang'])) {
    foreach ($_SESSION['giohang'] as $productId => $quantity) {
        $stmt = $pdo->prepare("SELECT Gia_sp FROM product WHERE Product_id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalPriceAll += $product['Gia_sp'] * $quantity;
    }
} else {
    echo "<script>alert('Giỏ hàng trống!'); window.location.href = 'cart.php';</script>";
    exit();
}

// Cấu hình VNPay
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "http://localhost:3000/wamp64/www/PHP_Thuan_Edit%20-%20Copy/vnpay_return.php";
$vnp_TmnCode = "0S8Y52K1"; // Mã website
$vnp_HashSecret = "C0Q52E27NNPQYTAS8R0J7DPT51ISMWMO"; // Chuỗi bí mật


$vnp_Amount = $totalPriceAll * 100000;

$vnp_TxnRef = date("YmdHis") . rand(1000, 9999);
$vnp_OrderInfo = "Thanh toan don hang";
$vnp_OrderType = "billpayment";
$vnp_Locale = "vn";
$vnp_BankCode = "NCB";
$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef,
);

if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
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

$vnp_Url = $vnp_Url . "?" . $query;
if (isset($vnp_HashSecret)) {
    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
}
header('Location: ' . $vnp_Url);
exit();
?>
