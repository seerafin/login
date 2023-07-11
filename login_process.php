<?php
// Start a session
session_start();

// Database connection details
$host = 'your_database_host';
$username = 'your_database_username';
$password = 'your_database_password';
$database = 'your_database_name';

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

// Get user input from the login form
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare and execute a query to fetch user data
$stmt = $conn->prepare('SELECT id, password FROM users WHERE username = ?');
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->store_result();

// Check if a user with the given username exists
if ($stmt->num_rows === 1) {
  // Bind the result to variables
  $stmt->bind_result($userId, $hashedPassword);
  $stmt->fetch();

  // Verify the provided password against the stored hashed password
  if (password_verify($password, $hashedPassword)) {
    // Password is correct, create a session
    $_SESSION['user_id'] = $userId;
    $_SESSION['username'] = $username;
    header('Location: dashboard.php');
  } else {
    // Password is incorrect
    header('Location: login.php?error=invalid_credentials');
  }
} else {
  // User does not exist
  header('Location: login.php?error=invalid_credentials');
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>
