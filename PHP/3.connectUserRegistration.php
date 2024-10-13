<?php
echo "PHP is working!";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch form data
$name = $_POST['name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$contact = $_POST['contact'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$occupation = $_POST['occupation'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'datamechanicfinder');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO user(name, email, username, password, contact, dob, gender, occupation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $email, $username, $password, $contact, $dob, $gender, $occupation);

    if ($stmt->execute()) {
        // Output success message with JavaScript for redirection
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Success</title>
            <style>
                .success-box {
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    padding: 20px;
                    background-color: #dff0d8;
                    border: 2px solid #d6e9c6;
                    border-radius: 5px;
                    text-align: center;
                    font-family: Arial, sans-serif;
                }
            </style>
            <script>
                setTimeout(function() {
                    alert("Registration successful! Login once again"); 
                    window.location.href = "../index.html";}, 3000); 
            </script>
        </head>
        <body>
            <div class="success-box">
                <h2>Registration successfully completed!</h2>
                <p>You will be redirected shortly...</p>
            </div>
        </body>
        </html>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
