<?php
include 'connect.php';
include 'include/check_login.php';

//neu role be hon 3 thi khong xoa duoc
if ($_SESSION['Role'] < 3) {
    header('location: role_error.php');
    exit;
  }
  

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM product WHERE Product_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $session = $_SESSION['Username'];
    $date = time();
    $sql2 = "INSERT INTO history(Username, Action, Timee) VALUES (:username, :action, :time)";
    $stmt2 = $pdo->prepare($sql2);
    $action = "Xóa sản phẩm: $id";
    $stmt2->bindParam(':username', $session, PDO::PARAM_STR);
    $stmt2->bindParam(':action', $action, PDO::PARAM_STR);
    $stmt2->bindParam(':time', $date, PDO::PARAM_INT);
    $stmt2->execute();

    header('location: list_order.php');
    exit;
}
?>
