<?php

// Set session timeout duration (14 minutes)
$timeout_duration = 14 * 60;

// Check if the session was last updated
if (isset($_SESSION['last_activity'])) {
    $time_since_last_activity = time() - $_SESSION['last_activity'];

    // If the session has expired, destroy the session and redirect to sign-in page
    if ($time_since_last_activity > $timeout_duration) {
        session_unset();
        session_destroy();
        header("Location: signin.php?timeout=1");
        exit();
    }
}

// Update session's last activity time
$_SESSION['last_activity'] = time();
?>
