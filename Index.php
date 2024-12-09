<?php
session_start();
?>
<?php include 'navbar.php'; ?>
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
    
    <!-- Main Content -->
    <div class="container mt-5">
        <div class="text-center">
            <h1>Welcome to NorWaste Donation</h1>
            <p class="lead">Join us in fighting food waste and supporting Sustainable Development Goals (SDG).</p>
            <a class="btn btn-primary btn-lg" href="donate.html" role="button">Donate Now</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
