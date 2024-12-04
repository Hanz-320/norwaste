<?php
session_start(); // Start session to check user login status

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    // If not logged in, redirect to login page with a message
    header("Location: signin.html?error=not_logged_in");
    exit;
}

// Check if the donation amount was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];

    if ($amount <= 0) {
        echo "<p>Invalid donation amount. Please enter a positive number.</p>";
        echo "<a href='donation.php'>Go back to donation page</a>";
        exit;
    }

    // Save the donation (e.g., to a database or a log file)
    $user = $_SESSION['user'];
    $date = date("Y-m-d H:i:s");

    // Database connection (update credentials as needed)
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'NorWaste';

    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert donation into database
    $stmt = $conn->prepare("INSERT INTO donations (user_email, amount, donation_date) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $_SESSION['user'], $amount, $date);

    if ($stmt->execute()) {
        echo "<p>Thank you for your donation of RM $amount!</p>";
        echo "<a href='index.html'>Return to home</a>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
        echo "<a href='donation.php'>Go back to donation page</a>";
    }

    $stmt->close();
    $conn->close();
}
?>
