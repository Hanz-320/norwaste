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
                <!-- Conditional Display for Donate -->
                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="donate.php">Donate</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about_us.php">About Us</a>
                </li>
            </ul>
            <div class="d-flex" id="auth-buttons">
                <?php if (isset($_SESSION['username'])): ?>
                    <!-- Show Profile and Logout if logged in -->
                    <a href="profile.php" class="btn btn-profile me-2"><?php echo $_SESSION['username']; ?></a>
                    <a href="logout.php" class="btn btn-logout">Logout</a>
                <?php else: ?>
                    <!-- Show Login and Sign Up if not logged in -->
                    <a href="signin.php" class="btn btn-login me-2">Login</a>
                    <a href="signup.php" class="btn btn-signup">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
