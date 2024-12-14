<?php
session_start();
?>
<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - NorWaste</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Hero Section -->
    <div class="container-fluid text-white text-center py-5" style="background: linear-gradient(135deg, #4B0082, #8A2BE2);">
        <h1 class="display-4 fw-bold">About NorWaste</h1>
        <p class="lead mt-3">Reducing food waste and supporting communities, one meal at a time.</p>
    </div>

    <!-- Content Section -->
    <div class="container my-5">
        <!-- Background Section -->
        <section class="mb-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>Background</h2>
                    <p>NorWaste aims to solve the issue of food waste by bridging the gap between businesses with excess food and organizations that serve communities in need. These include charities, orphanages, and old folk’s homes.</p>
                    <p>Frequently, food that is perfectly edible is discarded because it is overstocked or nearing expiration. NorWaste focuses on redirecting this food to ensure it reaches the right people, helping reduce waste while supporting needy individuals. Our platform facilitates efficient food sharing, contributing to sustainable practices within the community.</p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="images/norwaste.png" alt="Background" class="img-fluid me-4" style="max-width: 240px;">
                </div>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="mb-5">
            <div class="row align-items-center flex-md-row-reverse">
                <div class="col-md-6">
                    <h2>Our Mission</h2>
                    <p>Our mission is to prevent food from being wasted. We strive to create a socially focused system where excess food can easily be donated and distributed to those in need. This benefits not just the people who receive the food but also the businesses donating it, as it helps them reduce waste and promote sustainability efforts.</p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="images/donation.jpg" alt="Our Mission" class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </section>

        <!-- Goal Section -->
        <section class="mb-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>Our Goal</h2>
                    <p>Our primary goal is to develop a user-friendly platform that makes it quick and simple to distribute excess food in real time. We aim to help businesses reduce their environmental impact by offering a sustainable alternative to food disposal. At the same time, we ensure that charities, orphanages, and old folk’s homes have access to nutritious food.</p>
                    <p>Additionally, we aim to promote sustainable living by encouraging a culture of sharing and environmental responsibility within communities. Businesses can easily distribute available food donations on NorWaste, and community organizations can efficiently receive and collect them. This real-time interaction ensures food reaches the right people on time and strengthens local community ties by promoting collaboration.</p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="images/collect food.jpg" alt="Our Goal" class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </section>
    </div>

    <!-- Call to Action Section -->
    <div class="container-fluid text-white text-center py-5" style="background: linear-gradient(135deg, #8A2BE2, #4B0082);">
        <h2 class="fw-bold">Join Us in Making a Difference</h2>
        <p class="mt-3">Your support is vital in helping us reduce food waste and provide for those in need.</p>
        <a href="donate.php" class="btn btn-primary btn-lg mt-3">Donate Now</a>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
