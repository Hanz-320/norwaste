<?php
// logout.php
session_start();

// Destroy the session
session_destroy();

// Redirect to the homepage or login page
header("Location: index.php");
exit;
?>
