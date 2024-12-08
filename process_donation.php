<?php
include 'database.php'; // Include database connection

// Collect and sanitize input
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$amount = (float) $_POST['amount'];

// Insert into database
$stmt = $conn->prepare("INSERT INTO donations (user_id, amount) VALUES ((SELECT user_id FROM users WHERE email = ?), ?)");
$stmt->bind_param("sd", $email, $amount);

$success = $stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    <!-- Overlay -->
    <div id="overlay"></div>

    <!-- Thank You Popup -->
    <div id="thankYouPopup">
        <?php if ($success): ?>
            <h3>Thank You!</h3>
            <p>Thank you for your donation, <strong><?php echo $name; ?></strong>. Your generosity is greatly appreciated!</p>
            <button class="btn btn-success" onclick="closePopup()">Close</button>
        <?php else: ?>
            <h3>Error</h3>
            <p>Something went wrong. Please try again.</p>
            <button class="btn btn-danger" onclick="closePopup()">Close</button>
        <?php endif; ?>
    </div>

    <script>
        // Show the popup on page load
        document.getElementById("overlay").style.display = "block";
        document.getElementById("thankYouPopup").style.display = "block";

        // Close the popup
        function closePopup() {
            document.getElementById("thankYouPopup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
            window.location.href = "index.php"; // Redirect to the homepage or another page
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
