<?php
session_start();
include 'navbar.php';
include 'database.php'; // Ensure this file contains your database connection setup

// Fetch total donations from the database
$totalRaised = 0;
$goal = 10000; // Set your donation goal

$sql = "SELECT SUM(amount) AS total FROM donations"; // Replace 'donations' with your actual donations table
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $totalRaised = $row['total'] ?? 0; // If no donations, default to 0
}

// Calculate progress
$progress = ($totalRaised / $goal) * 100;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NorWaste Donation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Hero Section -->
    <div class="container-fluid p-5 text-center text-warning" style="background: url('images/zero.jpg') no-repeat center center/cover;">
        <div class="overlay" style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.1)); color: white;padding: 50px;">
            <h1 class="display-4 fw-bold">Serving Hunger, Building Communities</h1>
            <p class="lead">Empowering lives through food. Your support can help us make a difference.</p>
            <p>Kindness is the greatest thing. Lend your helping hand. Join us in food banking today!</p>
            <div class="mt-4">
                <a href="about_us.php" class="btn btn-light btn-lg me-3">About Us</a>
                <a href="donate.php" class="btn btn-primary btn-lg">Donate Now</a>
            </div>
        </div>
    </div>

    <!-- Goal Tracker Section -->
<div class="container my-5">
    <div class="card p-4 shadow-lg" style="border-radius: 10px; background-color: #f8f9fa;">
        <h2 class="text-center">Funds Collected</h2>
        <p class="text-center">Your contributions make a difference! See how close we are to achieving our goal.</p>
        
        <!-- Progress Bar -->
        <div class="progress mb-3" style="height: 30px;">
            <div 
                class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                role="progressbar" 
                style="width: <?php echo min($progress, 100); ?>%;" 
                aria-valuenow="<?php echo $progress; ?>" 
                aria-valuemin="0" 
                aria-valuemax="100">
                <?php echo round($progress, 2); ?>%
            </div>
        </div>

        <!-- Donation Summary -->
        <div class="text-center">
            <p><strong>Total Raised:</strong> RM<?php echo number_format($totalRaised, 2); ?></p>
            <p><strong>Goal:</strong> RM<?php echo number_format($goal, 2); ?></p>
            <p><strong>Progress:</strong> <?php echo round($progress, 2); ?>%</p>
        </div>
    </div>
</div>


    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
