<?php
session_start(); // Start the session
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch form data
$username = $_POST['username'];
$password = $_POST['password'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'dataMechanicFinder');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Securely fetch the username
$post_username = mysqli_real_escape_string($conn, $username);

// Check in the user table

$stmt = $conn->prepare("SELECT username, name FROM user WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $post_username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User found
    $row = $result->fetch_assoc();
    $_SESSION['userperu'] = $row['name']; // Store the user's name in the session
    $_SESSION['loggedin'] = true; // Optionally track if the user is logged in
    echo '
    <script>
        alert("Login successful as user!"); 
        window.location.href = "../HTML/5.MainPage.php"; 
    </script>';
} else {
    // Check in the mechanic table
    $stmt = $conn->prepare("SELECT name FROM mechanic WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $post_username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Mechanic found
        $row = $result->fetch_assoc();
        $_SESSION['userperu'] = $row['name']; // Store the mechanic's name in the session
        $_SESSION['loggedin'] = true; // Optionally track if the user is logged in
        echo '
        <script>
            alert("Login successful as mechanic!"); 
            window.location.href = "../HTML/5.MainPage.php"; 
        </script>';
    } else {
        // No match found
        echo '
        <script>
            alert("Invalid username or password. Please try again.");
            window.history.back();
        </script>';
    }
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
