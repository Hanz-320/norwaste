<?php 
include 'navbar.php';
session_start();

// Get error messages and saved data from session
$errors = isset($_SESSION['signup_errors']) ? $_SESSION['signup_errors'] : [];
$saved_data = isset($_SESSION['signup_data']) ? $_SESSION['signup_data'] : [];
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;

// Clear session messages after use
unset($_SESSION['signup_errors']);
unset($_SESSION['signup_data']);
unset($_SESSION['success_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Sign Up</h1>

    <!-- Display Success Message -->
    <?php if ($success_message): ?>
        <div class="alert alert-success text-center">
            <strong>Account successfully created!</strong> Welcome, <?php echo htmlspecialchars($success_message); ?>!
        </div>
    <?php endif; ?>

    <!-- Display Validation Errors -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Sign Up Form -->
    <form action="process_signup.php" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" 
                   value="<?php echo isset($saved_data['first_name']) ? htmlspecialchars($saved_data['first_name']) : ''; ?>" 
                   required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" 
                   value="<?php echo isset($saved_data['last_name']) ? htmlspecialchars($saved_data['last_name']) : ''; ?>" 
                   required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="<?php echo isset($saved_data['email']) ? htmlspecialchars($saved_data['email']) : ''; ?>" 
                   required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
