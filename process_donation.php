<?php 
include 'navbar.php';
include 'database.php';

session_start();  // Make sure session is started

$message = "";
$first_name = $last_name = $email = ""; // Initialize variables to store previous input

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];

    // Check if the amount is valid
    if (!is_numeric($amount) || $amount <= 0) {
        $_SESSION['error_message'] = "Invalid donation amount.";
        header("Location: donate.php");
        exit();
    }

    $user_id = $_SESSION['user_id']; // User ID from session
    $sql = "INSERT INTO donations (user_id, amount, donated_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $user_id, $amount);

    // Execute the query
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Thank you for your donation!";
    } else {
        $_SESSION['error_message'] = "Failed to process your donation. Please try again.";
        header("Location: donate.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation</title>
    <style>
        /* Styling for success popup */
        #successPopup {
            position: fixed;
            top: 10%;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            max-width: 400px;
            background-color: #28a745;
            color: white;
            padding: 20px;
            border-radius: 10px;
            display: none;
            z-index: 9999;
            text-align: center;
        }

        /* Overlay for the page when success popup is visible */
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 9998;
        }

        /* Close button for success popup */
        #closePopupBtn {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #218838;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        #closePopupBtn:hover {
            background-color: #1e7e34;
        }
    </style>
</head>
<body>

<!-- Donation Form -->
<form method="POST" action="process_donation.php">
    <div>
        <label for="amount">Donation Amount:</label>
        <input type="text" name="amount" id="amount" required>
    </div>
    <button type="submit">Donate</button>
</form>

<!-- Success Popup -->
<div id="successPopup">
    <h3>Thank You for Your Donation!</h3>
    <button id="closePopupBtn">Close</button>
</div>

<!-- Overlay to darken the background when popup is active -->
<div id="overlay"></div>

<!-- Error Message -->
<?php
if (isset($_SESSION['error_message'])) {
    echo '<div style="color: red; text-align: center; margin-top: 20px;">';
    echo $_SESSION['error_message'];
    echo '</div>';
    unset($_SESSION['error_message']);
}
?>

<script>
    // Check if there is a success message in session
    <?php if (isset($_SESSION['success_message'])): ?>
        // Show the success popup and overlay
        document.getElementById('successPopup').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
        
        // Close the popup after 5 seconds
        setTimeout(function() {
            document.getElementById('successPopup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
            window.location.href = 'donate.php'; // Redirect back to the donate page
        }, 5000); // Auto hide after 5 seconds
    <?php 
        unset($_SESSION['success_message']); // Clear success message
    endif; ?>

    // Close the popup manually when the button is clicked
    document.getElementById('closePopupBtn').addEventListener('click', function() {
        document.getElementById('successPopup').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
        window.location.href = 'donate.php'; // Redirect after closing popup
    });
</script>

</body>
</html>
