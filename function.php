<?php
// functions.php

include 'database.php'; // Database connection

// Signup function
function signup($username, $password) {
    global $pdo;

    // Check if the username already exists
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    if ($stmt->rowCount() > 0) {
        return "Username already exists.";
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user
    $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
    $stmt->execute(['username' => $username, 'password' => $hashedPassword]);

    return true;
}

// Login function
function login($username, $password) {
    global $pdo;

    // Check if the username exists
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Start session and store user data
        session_start();
        $_SESSION['username'] = $username;
        return true;
    } else {
        return false;
    }
}

