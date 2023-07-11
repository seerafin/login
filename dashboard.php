<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

// Display the user's username
$username = $_SESSION['username'];
echo "<h2>Welcome, $username!</h2>";

// Add the rest of your dashboard content here
?>
