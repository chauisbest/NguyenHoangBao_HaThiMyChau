<?php 
include 'connect.php';         



if ($_SESSION['Role'] < 3) { // Chỉ cho phép người dùng có vai trò >= 3 thực hiện xóa
    header('location: role_error.php'); 
    exit(); 
}

// Kiểm tra xem có tham số 'id' được truyền vào không
if (isset($_GET['id'])) {
    $id = $_GET['id']; 

    // Kiểm tra xem người dùng có đang đăng nhập không
    $sqlc = "SELECT * FROM users WHERE ID = :id";
    $stmtc = $pdo->prepare($sqlc);  
    $stmtc->execute(['id' => $id]); 

    if ($stmtc->rowCount() === 0) { 
        // Nếu không tìm thấy người dùng, hiển thị thông báo và chuyển hướng
        echo("<script>alert('Người dùng không tồn tại - Không thể xóa');</script>");
        echo("<script>window.location = 'list_customer.php';</script>");
    } else {
        // Nếu tìm thấy người dùng, tiến hành xóa
        $sql = "DELETE FROM users WHERE ID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]); 

        // Ghi lại hành động xóa vào bảng lịch sử
        $session = $_SESSION['Username']; 
        $date = time();                  

        $sql2 = "INSERT INTO history (Username, Action, Timee) 
                 VALUES (:session, :action, :date)";
        $stmt2 = $pdo->prepare($sql2); 
        $stmt2->execute([
            'session' => $session,         
            'action' => "Xóa User: $id",   
            'date' => $date                
        ]);

        // Chuyển hướng về danh sách người dùng sau khi xóa
        header('location: list_customer.php');
        exit(); // Dừng thực thi script
    }
}

?>
