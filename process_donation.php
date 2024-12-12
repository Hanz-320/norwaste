<?php
session_start();
include 'navbar.php';
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];

    if (!is_numeric($amount) || $amount <= 0) {
        $_SESSION['error_message'] = "Invalid donation amount.";
        header("Location: donate.php");
        exit();
    }

    $user_id = $_SESSION['user_id']; // User ID from session
    $sql = "INSERT INTO donations (user_id, amount, donated_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $user_id, $amount);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Thank you for your donation!";
        $_SESSION['donation_amount'] = $amount; // Store amount for display
        header("Location: thank_you.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Failed to process your donation. Please try again.";
        header("Location: donate.php");
        exit();
    }
}
?>
