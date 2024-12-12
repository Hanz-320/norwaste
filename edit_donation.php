<?php
include 'database.php'; // Include database connection
session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit();
}

// Check if donation ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['error_message'] = "No donation ID provided.";
    header("Location: admin_dashboard.php");
    exit();
}

$donation_id = intval($_GET['id']);

// Fetch donation details
$sql = "SELECT * FROM donations WHERE donation_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $donation_id);
$stmt->execute();
$result = $stmt->get_result();
$donation = $result->fetch_assoc();

if (!$donation) {
    $_SESSION['error_message'] = "Donation not found.";
    header("Location: admin_dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount']);

    if ($amount <= 0) {
        $_SESSION['error_message'] = "Invalid donation amount.";
    } else {
        $update_sql = "UPDATE donations SET amount = ? WHERE donation_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("di", $amount, $donation_id);

        if ($update_stmt->execute()) {
            $_SESSION['success_message'] = "Donation updated successfully.";
        } else {
            $_SESSION['error_message'] = "Failed to update donation.";
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
    <title>Edit Donation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Edit Donation</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="amount" class="form-label">Donation Amount</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="<?php echo htmlspecialchars($donation['amount']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Donation</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
