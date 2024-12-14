<?php
include 'database.php';

function processSignup($conn, $data) {
    $errors = [];

    // Sanitize inputs
    $first_name = htmlspecialchars($data['first_name']);
    $last_name = htmlspecialchars($data['last_name']);
    $email = htmlspecialchars($data['email']);
    $password = $data['password'];
    $confirm_password = $data['confirm_password'];

    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    } else {
        // Check if email already exists in the database
        $email_check_sql = "SELECT email FROM users WHERE email = ?";
        $stmt = $conn->prepare($email_check_sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "This email is already registered. Please use a different email.";
        }
        $stmt->close();
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

        if ($stmt->execute()) {
            return ["success" => true, "username" => $first_name . " " . $last_name];
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
    }

    // Store the form data for repopulating fields
    $_SESSION['signup_data'] = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
    ];

    return ["success" => false, "errors" => $errors];
}

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = processSignup($conn, $_POST);

    if ($result['success']) {
        unset($_SESSION['signup_data']);
        $_SESSION['success_message'] = $result['username'];
        header("Location: signup.php");
    } else {
        $_SESSION['signup_errors'] = $result['errors'];
        header("Location: signup.php");
    }
    exit();
}
