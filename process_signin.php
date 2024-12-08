<?php
include 'database.php';
session_start(); // Ensure session is started

// Get data from POST request
$email = $_POST['email'];
$password = $_POST['password'];

// Check user credentials
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['username'] = $user['first_name'];  // Assuming 'id' is the user's unique identifier
        $_SESSION['email'] = $user['email']; // Store first name for greeting

        // Redirect to homepage/dashboard after successful login
        header("Location: index.php");
        exit(); // Ensure no further code is executed after redirection
    } else {
        // Invalid credentials
        $_SESSION['error_message'] = 'Invalid credentials. Please try again.';
        header("Location: signin.php");
        exit();
    }
} else {
    // No user found with that email
    $_SESSION['error_message'] = 'No user found with that email.';
    header("Location: signin.php");
    exit();
}
?>
