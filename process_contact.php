<?php
session_start();
include 'database.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validation
    $errors = [];
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email address is required.";
    }
    if (empty($message)) {
        $errors[] = "Message cannot be empty.";
    }

    if (empty($errors)) {
        // Save to database
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Thank you for contacting us! We'll get back to you soon.";
            header("Location: contact_us.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Something went wrong. Please try again later.";
        }
    } else {
        $_SESSION['error_message'] = implode("<br>", $errors);
    }
}
header("Location: contact.php");
exit();
