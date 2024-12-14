<?php
include 'database.php'; // Database connection
session_start();
// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

// Determine the user ID
$is_admin = $_SESSION['admin_logged_in'] ?? false;
$user_id = $is_admin && isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo '<p class="error">Invalid user ID or session.</p>';
    exit();
}

// Fetch user data
$sql = "SELECT first_name, last_name, email FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
if (!$user) {
    echo '<p class="error">No such user found.</p>';
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = $is_admin ? trim($_POST['email']) : $user['email'];
    $password = trim($_POST['password']);
    
    // Validation
    $errors = [];
    if (empty($first_name)) $errors[] = 'First name is required.';
    if (empty($last_name)) $errors[] = 'Last name is required.';
    if ($password && strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
    
    if (!$errors) {
        $update_fields = ['first_name = ?', 'last_name = ?'];
        $params = [$first_name, $last_name];

        if ($is_admin && $email) {
            $update_fields[] = 'email = ?';
            $params[] = $email;
        }
        
        if ($password) {
            $update_fields[] = 'password = ?';
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Update query
        $params[] = $user_id;
        $sql = "UPDATE users SET " . implode(', ', $update_fields) . " WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(str_repeat('s', count($params) - 1) . 'i', ...$params);
        
        if ($stmt->execute()) {
            $_SESSION['username'] = $first_name; // Update session for regular users
            $_SESSION['success_message'] = 'Profile updated successfully.';
            header("Location: " . ($is_admin ? 'admin_dashboard.php' : 'profile.php'));
            exit();
        } else {
            $errors[] = 'Failed to update profile.';
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
        <h2><?php echo $is_admin ? 'Edit User' : 'Edit Profile'; ?></h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
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
            <?php if ($is_admin): ?>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="password" class="form-label">New Password (optional)</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="<?php echo $is_admin ? 'admin_dashboard.php' : 'profile.php'; ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
