<?php
include 'database.php'; // Include your database connection file
session_start();
// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all users from the database
$sql_users = "SELECT user_id, first_name, last_name, email FROM users";
$result_users = $conn->query($sql_users);

// Fetch all donations from the database
$sql_donations = "SELECT donation_id, user_id, amount, donated_at FROM donations ORDER BY donated_at DESC";
$result_donations = $conn->query($sql_donations);

// Fetch all messages from the contact_message table
$sql_messages = "SELECT id, name, email, message, created_at FROM contact_messages ORDER BY created_at DESC";
$result_messages = $conn->query($sql_messages);

// Handle donation deletion
if (isset($_GET['delete_donation'])) {
    $donation_id = intval($_GET['delete_donation']);
    $delete_sql = "DELETE FROM donations WHERE donation_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $donation_id);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Donation deleted successfully.";
    } else {
        $_SESSION['error_message'] = "Failed to delete donation.";
    }
    header("Location: admin_dashboard.php");
    exit();
}

// Handle contact message deletion
if (isset($_GET['delete_message'])) {
    $message_id = intval($_GET['delete_message']);
    $delete_sql = "DELETE FROM contact_messages WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $message_id);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Message deleted successfully.";
    } else {
        $_SESSION['error_message'] = "Failed to delete message.";
    }
    header("Location: admin_dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Admin Dashboard</h1>
    <!-- Logout Button -->
    <a href="logout.php" class="btn btn-danger mb-3">Logout</a>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <!-- Users Table -->
    <h2>Users</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_users->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="?delete=<?php echo $row['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Donations Table -->
    <h2 class="mt-5">Donations</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Donation ID</th>
                <th>User ID</th>
                <th>Amount</th>
                <th>Donated Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_donations->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['donation_id']; ?></td>
                    <td><?php echo $row['user_id']; ?></td>
                    <td>$<?php echo number_format($row['amount'], 2); ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['donated_at'])); ?></td>
                    <td>
                        <a href="edit_donation.php?id=<?php echo $row['donation_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="?delete_donation=<?php echo $row['donation_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this donation?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Contact Messages Table -->
    <h2 class="mt-5">Contact Messages</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_messages->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['created_at'])); ?></td>
                    <td>
                        <a href="edit_message.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="?delete_message=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
