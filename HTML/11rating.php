<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Use your actual password here if different
$dbname = "datamechanicfinder";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$averageRating = 0;
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted rating
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

    if ($rating > 0) {
        // Insert the rating into the database
        $stmt = $conn->prepare("INSERT INTO rating (rate) VALUES (?)");
        $stmt->bind_param("i", $rating);

        if ($stmt->execute()) {
            $message = "Thanks for submitting your feedback!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Invalid rating!";
    }

    // Calculate the average rating
    $result = $conn->query("SELECT AVG(rate) AS averageRating FROM rating");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $averageRating = round($row['averageRating'], 1); // Round to 1 decimal place
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star Rating System</title>
    <style>


        .stars {
            display: flex;
            cursor: pointer;
            display: inline-block;
        }

        .star {
            font-size: 4em;
            color: grey;
            margin: 0 5px;
            transition: color 0.3s;
        }

        .star.gold {
            color: gold;
        }

        .feedback-message {
            padding-top: 10px;
            font-size: 22px;
            color: green;
            display: block;
        }

        button {
            background-color: gold;
            color: black;
            font-size: large;
            border: 1px solid black;
            transition: box-shadow 0.3s ease;
            padding:10px;
            border-radius: 5px;
        }

        button:hover {
            background-color: black;
            box-shadow: 0 0 5px gold, 0 0 5px gold;
            color: gold;
            font-weight: bold;
        }

        button:click {
            background-color: gold;
        }

        .container {
            text-align: center;
            /* Center text and inline elements */
            margin-bottom: 50px;
        }

        button {
            display: inline-block;
            margin-top: 20px;
        }

        .info{
            color:gold;
            padding-bottom: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="post" action="">
            <div class="stars" id="stars">
                <label>
                    <input type="radio" name="rating" value="1" hidden>
                    <span class="star" data-index="1">&#9733;</span>
                </label>
                <label>
                    <input type="radio" name="rating" value="2" hidden>
                    <span class="star" data-index="2">&#9733;</span>
                </label>
                <label>
                    <input type="radio" name="rating" value="3" hidden>
                    <span class="star" data-index="3">&#9733;</span>
                </label>
                <label>
                    <input type="radio" name="rating" value="4" hidden>
                    <span class="star" data-index="4">&#9733;</span>
                </label>
                <label>
                    <input type="radio" name="rating" value="5" hidden>
                    <span class="star" data-index="5">&#9733;</span>
                </label>
            </div>
            <div class="ratingSubmitButton"><button class="btn btn-dark" type="submit">Submit</button></div>
            
        </form>

        <div class="feedback-message">
            <?php echo $message; ?>
        </div>

        <div class="info">
            <h1 id="submissionInfo">Average Rating: <?php echo $averageRating; ?></h1>
        </div>
    </div>

    <script>
        const stars = document.querySelectorAll('.star');
        const radioButtons = document.querySelectorAll('input[name="rating"]');

        radioButtons.forEach((radio, index) => {
            radio.addEventListener('change', () => {
                stars.forEach(star => star.classList.remove('gold'));
                for (let i = 0; i <= index; i++) {
                    stars[i].classList.add('gold');
                }
            });
        });
    </script>
</body>

</html>