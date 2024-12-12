<?php
include 'database.php';
session_start(); // Ensure session is started

// Get data from POST request
$first_name = htmlspecialchars($_POST['first_name']);
$last_name = htmlspecialchars($_POST['last_name']);
$email = htmlspecialchars($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Insert new user
$sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $first_name, $last_name, $email, $password);

if ($stmt->execute()) {
    echo "Sign up successful. Welcome, $first_name!";
} else {
    echo "Error: " . $stmt->error;
}
?>
