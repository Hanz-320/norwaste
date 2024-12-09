<?php
include 'database.php';
session_start(); // Ensure session is started

// Get data from POST request
$email = $_POST['email'];
$password = $_POST['password'];

// Check for admin credentials in the 'admins' table
$sql_admin = "SELECT * FROM admins WHERE email = ?"; // Query for admin table
$stmt_admin = $conn->prepare($sql_admin);
$stmt_admin->bind_param("s", $email);
$stmt_admin->execute();
$result_admin = $stmt_admin->get_result();

if ($result_admin->num_rows > 0) { // Admin found
    $admin = $result_admin->fetch_assoc();
    if ($admin['email'] === $email && md5($password) === $admin['password']) { // Use MD5 for password comparison
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $email;

        // Redirect to the admin dashboard after successful login
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $_SESSION['error_message'] = 'Invalid admin credentials. Please try again.';
        header("Location: admin_login.php");
        exit();
    }
} else {
    // No admin found
    $_SESSION['error_message'] = 'No account found with that email.';
    header("Location: admin_login.php");
    exit();
}
?>
