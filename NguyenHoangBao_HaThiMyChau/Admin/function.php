<?php
include 'connect.php';

function checkquery($table) {
    global $pdo; // Sử dụng biến kết nối PDO toàn cục đã được khai báo trong connect.php

    // 1. Chuẩn bị truy vấn SQL
    // Lưu ý: Cẩn thận với việc chèn trực tiếp tên bảng vào câu lệnh SQL (tiềm ẩn SQL Injection)
    $sql = "SELECT * FROM $table"; 
    $stmt = $pdo->prepare($sql); // Chuẩn bị truy vấn SQL

    // 2. Thực thi truy vấn
    $stmt->execute();

    // 3. Trả về số lượng bản ghi trong bảng
    $count = $stmt->rowCount();
    return $count;
}
?>
