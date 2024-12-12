<?php 
session_start();

// Check if the user is logged in and if the email session is set
if (!isset($_SESSION['username']) ) {
    header("Location: signin.php"); // Redirect to sign-in page if not logged in
    exit;
}
?>
<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
        <p>Your profile information is shown below:</p>
        <p>Username: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>

        <!-- Edit Profile Link -->
        <a href="user_edit_profile.php" class="btn btn-primary">Edit Profile</a>

        <!-- Logout Button -->
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
