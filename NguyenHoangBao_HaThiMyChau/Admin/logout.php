<?php 
ob_start();
session_start();
include 'connect.php'; 

if (isset($_SESSION['Username'])) {
    $session = $_SESSION['Username'];
    $date = time();

    try {
        $sql2 = "INSERT INTO history(Username, Action, Timee) VALUES (:username, 'Đăng xuất', :time)";
        $stmt = $pdo->prepare($sql2);
        $stmt->bindParam(':username', $session, PDO::PARAM_STR);
        $stmt->bindParam(':time', $date, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error logging logout action: " . $e->getMessage();
        exit;
    }

    unset($_SESSION['Username']);
    session_destroy();
}

header('location: login.php');
exit;
?>
