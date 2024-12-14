<?php
include 'database.php'; // Include the database connection
session_start();
// Redirect if not logged in
if (!isset($_SESSION['user_logged_in']) || !isset($_SESSION['email'])) {
    header("Location: signin.php");
    exit();
}

// Get the user's email from the session
$email = $_SESSION['email'];

// Fetch user data
$sql = "SELECT first_name, last_name FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    echo '<p class="error">User not found. Please log in again.</p>';
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validation
    $errors = [];
    if (empty($first_name)) $errors[] = 'First name is required.';
    if (empty($last_name)) $errors[] = 'Last name is required.';
    if (!empty($password)) {
        if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
        if ($password !== $confirm_password) $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        // Update query
        $update_fields = ['first_name = ?', 'last_name = ?'];
        $params = [$first_name, $last_name];

        if (!empty($password)) {
            $update_fields[] = 'password = ?';
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        $params[] = $email; // Add email as the condition
        $sql = "UPDATE users SET " . implode(', ', $update_fields) . " WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);

        if ($stmt->execute()) {
            $_SESSION['username'] = $first_name; // Update the session username
            $_SESSION['success_message'] = 'Profile updated successfully.';
            header("Location: profile.php"); // Redirect to profile page
            exit();
        } else {
            $errors[] = 'Failed to update profile. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Profile</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">New Password (optional)</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter new password">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="profile.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
