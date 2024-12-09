<?php
session_start();
include 'database.php'; // Make sure to include your database connection file

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit();
}

// Check if a valid user ID was provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} elseif (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

// Fetch the user’s current data
$sql = "SELECT first_name, last_name, email FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo '<p class="error">No such user found.</p>';
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    
    // Validate and sanitize form inputs
    if (empty($_POST['first_name'])) {
        $errors[] = 'First name is required.';
    } else {
        $first_name = mysqli_real_escape_string($conn, trim($_POST['first_name']));
    }

    if (empty($_POST['last_name'])) {
        $errors[] = 'Last name is required.';
    } else {
        $last_name = mysqli_real_escape_string($conn, trim($_POST['last_name']));
    }

    if (empty($_POST['email'])) {
        $errors[] = 'Email is required.';
    } else {
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    }

    // If there are no errors, check if data has actually changed
    if (empty($errors)) {
        // Only update if any of the fields have changed
        if ($first_name != $user['first_name'] || $last_name != $user['last_name'] || $email != $user['email']) {
            // Check if the email is unique (excluding the current user)
            $sql = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $email, $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                // Update the user details
                $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sssi', $first_name, $last_name, $email, $id);

                if ($stmt->execute()) {
                    $_SESSION['success_message'] = 'User updated successfully.';
                    header('Location: admin_dashboard.php');
                    exit();
                } else {
                    $_SESSION['error_message'] = 'Failed to update user.';
                }
            } else {
                $_SESSION['error_message'] = 'Email already exists.';
            }
        } else {
            $_SESSION['error_message'] = 'No changes were made to the user data.';
        }
    } else {
        $_SESSION['error_message'] = implode('<br>', $errors);
    }
}

// Get the current user data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Edit User</h1>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <form action="edit_user.php" method="POST">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" name="first_name" value="<?php echo $user['first_name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" name="last_name" value="<?php echo $user['last_name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" required>
        </div>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
