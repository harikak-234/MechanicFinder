<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Your existing code...

$name = $_POST['name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$exp = $_POST['exp'];
$contact = $_POST['contact'];
$city = $_POST['city'];
$address = $_POST['address'];
//Database connection
$conn = new mysqli('localhost', 'root', '', 'datamechanicfinder');
if ($conn->connect_error) {
    die('connection failed: ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("insert into 
    mechanic(name,email, username,password, exp, contact, city, address) values(?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssisss", $name, $email, $username, $password, $exp, $contact, $city, $address);
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