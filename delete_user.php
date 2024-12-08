<?php
include 'database.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete user
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location: admin_users.php");
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Invalid request.";
}
?>
