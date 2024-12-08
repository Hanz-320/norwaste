<?php
include 'database.php';

// Get data from POST request
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$message = htmlspecialchars($_POST['message']);

// Save contact message
$sql = "INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    echo "Thank you for contacting us, $name! We will get back to you shortly.";
} else {
    echo "Error: " . $stmt->error;
}
?>
