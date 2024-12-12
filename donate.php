<?php
session_start();
?>
<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Support Our Cause</h1>
        <p class="text-center">Your donations help us achieve our mission!</p>
        <div class="text-center">
            <form action="process_donation.php" method="POST">
                <!-- Donation Amount Input -->
                <div class="mb-3">
                    <label for="amount" class="form-label">Enter Donation Amount</label>
                    <input type="number" class="form-control" id="amount" name="amount" min="1" required>
                </div>
                <!-- Donate Button -->
                <button type="submit" class="btn btn-primary">Donate Now</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
