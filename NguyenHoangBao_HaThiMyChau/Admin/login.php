<?php 
ob_start();
session_start();
include 'connect.php'; // Ensure this file connects using PDO
?>
<?php 
if(isset($_POST['Login'])) // Check if form is submitted
{
    $username = $_POST["Username"];
    $password = md5($_POST["Password"]);
    
    // Sanitize inputs to prevent SQL injection
    $username = strip_tags($username);
    $username = addslashes($username);
    $password = strip_tags($password);
    $password = addslashes($password);

    // Use prepared statements to avoid SQL injection
    $sql = "SELECT * FROM admin WHERE Username = :username AND Password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();

    // Check if user exists
    if ($stmt->rowCount() >= 1) {
        // Fetch user details
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $user = $row['Username'];
        $role = $row['Role'];

        // Store session information
        $_SESSION['Username'] = $username;
        $_SESSION['Role'] = $role;

        // Log the login action
        $session = $_SESSION['Username'];
        $date = time();
        $sql2 = "INSERT INTO history(Username, Action, Timee) VALUES (:username, 'Đăng nhập', :time)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':username', $session, PDO::PARAM_STR);
        $stmt2->bindParam(':time', $date, PDO::PARAM_INT);
        $stmt2->execute();

        // Redirect to home page
        header('location: index.php');
    } else {
        // Error message if login fails
        $login_error = "Tên đăng nhập hoặc mật khẩu không đúng !";
    }
}
?>

<?php 
include 'include/login_css.php';
?>
<div class="login">
    <div class="login-triangle"></div>

    <h2 class="login-header">Log in <?php if(isset($login_error)) {echo $login_error;} ?></h2>

    <form class="login-container" method="POST">
        <p><input type="text" placeholder="Username" name="Username"></p>
        <p><input type="password" placeholder="Password" name="Password"></p>
        <p><input type="submit" value="Login" name="Login"></p>
    </form>
</div>
