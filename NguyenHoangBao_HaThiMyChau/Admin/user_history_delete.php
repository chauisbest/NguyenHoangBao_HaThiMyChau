<?php 
include 'connect.php';
include 'include/check_login.php';

// Check if the user has the correct role
if ($_SESSION['Role'] < 3) {
  header('location: role_error.php');
  exit;
}

// Handle form submission
if (isset($_POST['del'])) {

  if (empty($_POST['chkid'])) {
    header('location: user_history.php');
    exit;
  } else {
    
    // Ensure $_POST['chkid'] is an array and filter out non-numeric values
    $chkid = array_filter($_POST['chkid'], 'is_numeric');
    
    if (!empty($chkid)) {
      // Join the IDs into a comma-separated string
      $id = implode(",", $chkid);
      
      try {
        // Prepare the DELETE query with the sanitized IDs
        $sql = "DELETE FROM history WHERE History_id IN ($id)";
        
        // Execute the query using PDO
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        // Redirect back after deletion
        header('location: user_history.php');
        exit;
        
      } catch (PDOException $e) {
        // Handle query failure
        echo "Error deleting records: " . $e->getMessage();
      }
    } else {
      // If no valid IDs were selected, redirect back
      header('location: user_history.php');
      exit;
    }
  }
}
?>
