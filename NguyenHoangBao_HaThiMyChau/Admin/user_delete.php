<?php 
include 'connect.php';
include 'include/check_login.php';

// Check if the user has the correct role (admin)
if ($_SESSION['Role'] < 3) {
    header('location: role_error.php');
    exit;
}

// Check if id is set in the URL and sanitize it
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT); // Sanitize the id
    $pdo->beginTransaction();

    try {
        // Delete admin user query with prepared statement
        $sql = "DELETE FROM admin WHERE User_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Log action in history table
            $session = $_SESSION['Username'];
            $date = time();
            $sql2 = "INSERT INTO history (Username, Action, Timee) VALUES (:Username, :Action, :Timee)";
            $stmt2 = $pdo->prepare($sql2);
            $action = "Deleted Admin User ID: $id";
            $stmt2->bindParam(':Username', $session, PDO::PARAM_STR);
            $stmt2->bindParam(':Action', $action, PDO::PARAM_STR);
            $stmt2->bindParam(':Timee', $date, PDO::PARAM_INT);

            if ($stmt2->execute()) {
                $pdo->commit(); // Commit the transaction
                header('location: list_user.php'); // Redirect to list of admins
                exit;
            } else {
                throw new Exception('Error: Unable to log the deletion action.');
            }
        } else {
            throw new Exception('Error: Unable to delete admin user.');
        }
    } catch (Exception $e) {
        $pdo->rollBack(); // Rollback the transaction
        echo $e->getMessage(); // Show error message
    }
} else {
    // If no valid id is provided, redirect to the admin list page
    header('location: list_user.php');
    exit;
}
?>
