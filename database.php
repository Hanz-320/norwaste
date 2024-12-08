<?php 
session_start();  // Make sure session is started here
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "norwaste";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
