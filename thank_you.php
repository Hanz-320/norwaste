<?php
session_start();
include 'database.php'; // Include your database connection file

if (!isset($_SESSION['success_message'])) {
    header("Location: donate.php");
    exit();
}

$donation_amount = $_SESSION['donation_amount'];
unset($_SESSION['success_message']); // Clear session message after use

// Fetch total donations from the database
$sql = "SELECT SUM(amount) AS total_donations FROM donations";
$result = $conn->query($sql);

// Initialize variables
$total_donations = 0;
$donation_goal = 10000; // Example goal: $10,000

if ($result && $row = $result->fetch_assoc()) {
    $total_donations = $row['total_donations'];
}

// Calculate progress percentage
$progress_percentage = min(100, ($total_donations / $donation_goal) * 100);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="thank_you.css">
    <title>Thank You</title>
</head>
<body>

<div class="container">
    <h1 class="thank-you">Thank You for Your Donation!</h1>
    <p>Your donation of <strong>RM<?= htmlspecialchars($donation_amount); ?></strong> will make a difference in people's lives.</p>

    <div class="impact">
        <p>Your contribution helps us provide clean water to families in need.</p>
    </div>

    <div class="progress">
        <h3>Campaign Progress:</h3>
        <progress value="<?= $total_donations; ?>" max="<?= $donation_goal; ?>"></progress>
        <div class="details">
            <p>Total Raised: <span>RM<?= number_format($total_donations, 2); ?></span></p>
            <p>Goal: <span>RM<?= number_format($donation_goal, 2); ?></span></p>
            <p>Progress: <span><?= round($progress_percentage, 2); ?>%</span></p>
        </div>
    </div>

    <div class="actions">
        <a href="donate.php" class="donate-more">Donate More</a>
        <a href="index.php">Return to Home</a>
    </div>
</div>

</body>
</html>
