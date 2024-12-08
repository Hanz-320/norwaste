<?php include 'navbar.php';
include 'database.php';
session_start();

$message = "";
$username = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert new user into the database
    $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $password);

    if ($stmt->execute()) {
        $username = $first_name . " " . $last_name;
        $message = "success";
    } else {
        $message = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script>
        function showSuccessPopup(username) {
            const popup = document.getElementById("successPopup");
            document.getElementById("usernameDisplay").textContent = username;
            popup.style.display = "block";
        }

        function closePopup() {
            document.getElementById("successPopup").style.display = "none";
            window.location.href = "signin.php";
        }
    </script>
    
</head>
<body>

<div id="overlay"></div>

<div class="container mt-5">
    <h1 class="text-center">Sign Up</h1>
    <form action="signup.php" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
</div>

<!-- Success Popup -->
<div id="successPopup">
    <h3>Sign Up Successful!</h3>
    <p>Welcome, <span id="usernameDisplay"></span>!</p>
    <button class="btn btn-success" onclick="closePopup()">Done</button>
</div>

<?php if ($message === "success"): ?>
    <script>
        document.getElementById("overlay").style.display = "block";
        showSuccessPopup("<?php echo $username; ?>");
    </script>
<?php elseif ($message === "error"): ?>
    <div class="alert alert-danger text-center mt-3">Error: Could not complete sign-up. Please try again.</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
