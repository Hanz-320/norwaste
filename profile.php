<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
        <p>Your profile information is shown below:</p>
        <p>Username: <?php echo $_SESSION['username']; ?></p>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>