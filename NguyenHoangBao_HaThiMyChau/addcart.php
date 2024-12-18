<?php 
  // Tạo ss để lưu thông tin
  session_start();

  // id_sp lấy từ product_details
  $id_sp = $_GET['id_sp'];

  if(isset($_SESSION['giohang'][$id_sp])){
    $_SESSION['giohang'][$id_sp] = $_SESSION['giohang'][$id_sp] + 1;
  }else{
    $_SESSION['giohang'][$id_sp] = 1;
  }
  header('location: product_summary.php');

?>