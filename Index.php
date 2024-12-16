<?php
session_start();
include 'navbar.php';
include 'database.php'; // Ensure this file contains your database connection setup
include 'session_timeout.php';

// Fetch total donations from the database
$totalRaised = 0;
$goal = 10000; // Set your donation goal

$sql = "SELECT SUM(amount) AS total FROM donations"; // Replace 'donations' with your actual donations table
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $totalRaised = $row['total'] ?? 0; // Default to 0 if no donations exist
}

// Calculate progress
$progress = min(($totalRaised / $goal) * 100, 100); // Ensure progress does not exceed 100%
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
        <div class="overlay" style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.1)); color: white; padding: 50px;">
            <h1 class="display-4 fw-bold">NorWaste</h1>
            <p class="lead">Empowering lives through food. Your support can help us make a difference.</p>
            <p>Kindness is the greatest thing. Lend your helping hand. Join us in food banking today!</p>
            <div class="mt-4">
                <a href="about_us.php" class="btn btn-light btn-lg me-3">About Us</a>
                <a href="donate.php" class="btn btn-primary btn-lg">Donate Now</a>
            </div>
        </div>
    </div>

    <!-- NorWaste Mission Section -->
    <div class="container-fluid p-5 text-center text-dark" style="background-color: #f4f4f4;">
        <div class="overlay" style="padding: 50px;">
            <h2 class="display-4 fw-bold">Committed to Achieving Zero Hunger</h2>
            <p class="lead">At NorWaste, we are dedicated to fighting hunger and food waste. By redistributing surplus food, we provide support to families in need, helping to build sustainable communities and contributing to the global fight against hunger.</p>
            <p>Our mission is aligned with the United Nations Sustainable Development Goal (SDG) of Zero Hunger. Through your donations, we provide food relief to those most affected by food insecurity, ensuring they have access to nutritious meals, regardless of their circumstances.</p>
            <p>We believe that no one should go to bed hungry, and together we can make a meaningful difference. Join us in this fight against hunger and help build a brighter future for vulnerable communities.</p>
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
                    style="width: <?= round($progress, 2); ?>%;" 
                    aria-valuenow="<?= round($progress, 2); ?>" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    <?= round($progress, 2); ?>%
                </div>
            </div>

            <!-- Donation Summary -->
            <div class="text-center">
                <p><strong>Total Raised:</strong> RM<?= number_format($totalRaised, 2); ?></p>
                <p><strong>Goal:</strong> RM<?= number_format($goal, 2); ?></p>
                <p><strong>Progress:</strong> <?= round($progress, 2); ?>%</p>
            </div>
        </div>
    </div>

    <!-- Zero Hunger Goals Section -->
<div class="container my-5 text-center">
    <h2 class="fw-bold mb-4">Our Contribution to SDG Zero Hunger</h2>
    <p class="lead mb-5">At NorWaste, we are committed to supporting the United Nations Sustainable Development Goal (SDG) 2: Zero Hunger. 
    Our aim is to eliminate hunger, ensure food security, and improve nutrition for all. Through food banking, redistribution of surplus food, 
    and providing nutritional support, we work to address food insecurity in underserved communities.</p>

    <p class="lead mb-4">With your help, we are working towards:</p>

    <!-- Row of Goal Cards -->
    <div class="row">
        <!-- Goal 1: Reducing Food Waste -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg" style="border-radius: 10px; background-color: #e3f2fd;">
                <div class="card-body">
                    <i class="bi bi-arrow-clockwise fs-1 text-primary mb-3"></i>
                    <h5 class="card-title">Reducing Food Waste</h5>
                    <p class="card-text">We redirect excess food to those in need, helping to reduce food waste and provide nutritious meals to vulnerable communities.</p>
                </div>
            </div>
        </div>

        <!-- Goal 2: Providing Food to Vulnerable Populations -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg" style="border-radius: 10px; background-color: #fff3e0;">
                <div class="card-body">
                    <i class="bi bi-house-door fs-1 text-warning mb-3"></i>
                    <h5 class="card-title">Providing Food to Vulnerable Populations</h5>
                    <p class="card-text">We ensure that children, refugees, low-income families, and others facing hunger have access to essential nutrition and support.</p>
                </div>
            </div>
        </div>

        <!-- Goal 3: Raising Awareness -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg" style="border-radius: 10px; background-color: #c8e6c9;">
                <div class="card-body">
                    <i class="bi bi-megaphone fs-1 text-success mb-3"></i>
                    <h5 class="card-title">Raising Awareness</h5>
                    <p class="card-text">We advocate for policies and raise awareness about the global hunger crisis to inspire collective action and long-term change.</p>
                </div>
            </div>
        </div>
    </div>

    <p class="lead mt-4">Together, we can make a lasting impact in achieving Zero Hunger by 2030. Join us in making the world a more sustainable and compassionate place.</p>
</div>

    <!-- Impact Stories Section -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Our Impact in Achieving Zero Hunger</h2>
        <div class="row">
            <!-- Story 1 -->
            <div class="col-md-6">
                <div class="card">
                    <img src="images/story1.jpg" class="card-img-top" alt="Impact Story 1">
                    <div class="card-body">
                        <h5 class="card-title">Fatoom in Yemen</h5>
                        <p class="card-text">Baby Fatoom and her family were driven from their home in Yemen by conflict: the number one cause of hunger. 
                        NorWaste helped provide essential nutrition to her mother, ensuring that Fatoom received the support she needed to survive and thrive. 
                        Nearly 50% of deaths among children under five are caused by hunger. This is why our work is vital in ensuring vulnerable populations 
                        have access to life-saving food.</p>
                    </div>
                </div>
            </div>
            <!-- Story 2 -->
            <div class="col-md-6">
                <div class="card">
                    <img src="images/story2.jpg" class="card-img-top" alt="Impact Story 2">
                    <div class="card-body">
                        <h5 class="card-title">Yuilmar in Colombia</h5>
                        <p class="card-text">Anayury, a refugee from Colombia, uses U.N. World Food Programme vouchers to buy food and provide a nutritious 
                        meal for her baby Yuilmar. Through our partnership with global organizations and local communities, NorWaste has helped families like Anayury's 
                        access nutritious food and vital support, empowering them to build a better future.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Picture Gallery Section -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Moments Captured</h2>
        <div class="row">
            <?php
            $galleryImages = ["images/moment1.jpg", "images/moment2.jpg", "images/moment3.jpg", "images/moment4.jpg"];
            foreach ($galleryImages as $image) : ?>
                <div class="col-md-3">
                    <img src="<?= $image; ?>" class="img-fluid rounded mb-3" alt="Gallery Image">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<!-- NorWaste Mission Section -->
<div class="container-fluid p-5 text-center text-dark" style="background-color: #f4f4f4;">
    <div class="overlay" style="padding: 50px;">
        <!-- Section Title -->
        <h2 class="display-4 fw-bold text-primary mb-4">Committed to Achieving Zero Hunger</h2>

        <!-- Mission Statement -->
        <p class="lead mb-4">At NorWaste, we are dedicated to fighting hunger and food waste. By redistributing surplus food, we provide support to families in need, helping to build sustainable communities and contributing to the global fight against hunger.</p>

        <p class="mb-4">Our mission is aligned with the United Nations Sustainable Development Goal (SDG) of Zero Hunger. Through your donations, we provide food relief to those most affected by food insecurity, ensuring they have access to nutritious meals, regardless of their circumstances.</p>

        <p class="mb-4">We believe that no one should go to bed hungry, and together we can make a meaningful difference. Join us in this fight against hunger and help build a brighter future for vulnerable communities.</p>

        <!-- Call-to-Action Buttons -->
        <div class="mt-5">
            <a href="about_us.php" class="btn btn-dark btn-lg me-3 py-3 px-4">Learn More About Us</a>
        </div>
    </div>
</div>

<!-- Donation Location Section -->
<div class="container-fluid" style="background-color: #4B0082; color: white; padding-top: 50px; padding-bottom: 50px;">
    <div class="container text-center">
        <h2 class="display-4 fw-bold text-light mb-4">Donate or Drop Off Food at Our Location</h2>
        <p class="lead mb-4">Help us continue our mission by donating food or dropping off non-perishable items at our designated location. Your generous contributions make a huge difference in the fight against hunger.</p>

        <!-- Donation Address -->
        <div class="mb-4">
            <h4 class="fw-bold mb-3">NorWaste Donation Center</h4>
            <!-- Address displayed in larger font -->
            <p style="font-size: 2rem; font-weight: bold;">5, Jalan Universiti, Bandar Sunway, 47500 Petaling Jaya, Selangor</p>
        </div>

        <!-- Call to Action to Donate -->
        <div class="mt-4">
            <a href="donate.php" class="btn btn-success btn-lg py-3 px-4">Make a Donation Today</a>
        </div>
    </div>
</div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
