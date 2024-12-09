<?php
include 'database.php';
session_start(); // Ensure session is started

// Get data from POST request
$email = $_POST['email'];
$password = $_POST['password'];

// Check if the email belongs to an admin first
$sql_admin = "SELECT * FROM admins WHERE email = ?";
$stmt_admin = $conn->prepare($sql_admin);
$stmt_admin->bind_param("s", $email);
$stmt_admin->execute();
$result_admin = $stmt_admin->get_result();

if ($result_admin->num_rows > 0) { // Admin found
    $admin = $result_admin->fetch_assoc();
    if ($admin['email'] === $email && md5($password) === $admin['password']) { // MD5 hash check for password
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $email;
        $_SESSION['username'] = $admin['username']; // Set admin's username (could be `admin` or `first_name`)

        // Redirect to the admin dashboard after successful login
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $_SESSION['error_message'] = 'Invalid admin credentials. Please try again.';
        header("Location: admin_login.php");
        exit();
    }
} else {
    // If not admin, check the 'users' table
    $sql_user = "SELECT * FROM users WHERE email = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("s", $email);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows > 0) { // User found
        $user = $result_user->fetch_assoc();
        if (password_verify($password, $user['password'])) { // Use password_verify for users
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_email'] = $email;
            $_SESSION['username'] = $user['first_name']; // Set user's first name as username

            // Redirect to the user dashboard after successful login
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error_message'] = 'Invalid user credentials. Please try again.';
            header("Location: signin.php");
            exit();
        }
    } else {
        // No user or admin found with that email
        $_SESSION['error_message'] = 'No account found with that email.';
        header("Location: signin.php");
        exit();
    }
}
?>
