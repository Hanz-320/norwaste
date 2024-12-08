<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NorWaste Donation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">NorWaste</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="donate.php">Donate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Us</a>
                    </li>
                </ul>
                <div class="d-flex" id="auth-buttons">
                    <?php if (isset($_SESSION['username'])): ?>
                        <!-- Display Profile Button when logged in -->
                        <a href="profile.php" class="btn btn-profile"><?php echo $_SESSION['username']; ?></a>
                        <a href="logout.php" class="btn btn-logout">Logout</a>
                    <?php else: ?>
                        <!-- Display Login and Sign Up buttons when not logged in -->
                        <a href="signin.php" class="btn btn-login me-2">Login</a>
                        <a href="signup.php" class="btn btn-signup">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <div class="container mt-5">
        <div class="text-center">
            <h1>Welcome to NorWaste Donation</h1>
            <p class="lead">Join us in fighting food waste and supporting Sustainable Development Goals (SDG).</p>
            <a class="btn btn-primary btn-lg" href="donate.html" role="button">Donate Now</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center py-3 mt-5">
        <p>&copy; 2024 Foodbank Donation. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
