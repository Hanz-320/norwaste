<?php
include 'database.php'; // Include database connection
session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit();
}

// Check if message ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['error_message'] = "No message ID provided.";
    header("Location: admin_dashboard.php");
    exit();
}

$message_id = intval($_GET['id']);

// Fetch message details
$sql = "SELECT * FROM contact_messages WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $message_id);
$stmt->execute();
$result = $stmt->get_result();
$message = $result->fetch_assoc();

if (!$message) {
    $_SESSION['error_message'] = "Message not found.";
    header("Location: admin_dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $msg_content = htmlspecialchars($_POST['message']);

    if (empty($name) || empty($email) || empty($msg_content)) {
        $_SESSION['error_message'] = "All fields are required.";
    } else {
        $update_sql = "UPDATE contact_messages SET name = ?, email = ?, message = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssi", $name, $email, $msg_content, $message_id);

        if ($update_stmt->execute()) {
            $_SESSION['success_message'] = "Message updated successfully.";
        } else {
            $_SESSION['error_message'] = "Failed to update message.";
        }

        header("Location: admin_dashboard.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Message</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Edit Message</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($message['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($message['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" required><?php echo htmlspecialchars($message['message']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Message</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
