<?php
session_start(); // Start session to track user login status

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    // If not logged in, redirect to login page with a message
    header("Location: signin.html?error=not_logged_in");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donate</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .donation-container {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      width: 400px;
    }
  </style>
</head>
<body>
  <div class="donation-container">
    <h3 class="text-center mb-4">Make a Donation</h3>
    <form action="process_donation.php" method="POST">
      <div class="mb-3">
        <label for="amount" class="form-label">Enter Amount (RM)</label>
        <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter amount in RM" required>
      </div>
      <div class="d-flex justify-content-between">
        <a href="index.html" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Confirm</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
