<?php
$conn = new mysqli('localhost', 'root', '', 'datamechanicfinder');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "SELECT name, username, exp, contact, city, address FROM mechanic";
$result = $conn->query($sql); //Table laga vasthadhi

$mechanics = array();
if ($result->num_rows > 0) {
    // Fetch each mechanic's details and store in an array
    while ($row = $result->fetch_assoc()) { //table lo okkokka row ni $row ki assign chesthadhi loop lo
        $mechanics[] = $row; //here assigning is happening
    }
} else {
    echo "No mechanics found.";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanic Master</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../CSS/5MainPage.css">

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg fixed-top">
            <img src="../ASSETS/1.logo.png" alt="Logo">
            <a class="navbar-brand fw-bold" href="#">Mechanic Master</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-bold gap-3">
                    <li class="nav-item active">
                        <a class="nav-link" href="#5Home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#6Maps">Maps</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#7Mechanics">Mechanics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#8Kart">Kart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#9Fuel">Fuel</a>
                    </li>
                    <li class="nav-item me-4">
                        <a class="nav-link" href="#10Contact">Contact</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <script>
        function toggleNavbar() {
            document.querySelector('.navbar').classList.toggle('active');
        }
    </script>

    <main>
        <?php session_start(); ?>

        <section id="5Home">
            <div class="service-banner">
                <div class="banner-content">
                    <div class="banner-row">
                        <div class="mechanic-image-container">
                            <img src="../ASSETS/5MainPageUncle.png" alt="Mechanic Image" class="mechanic-img">
                        </div>
                        <div class="service-info-container">
                            <div class="service-info">
                                <div class="<?php echo isset($_SESSION['userperu']) ? 'logged-in' : 'guest'; ?>">
                                    <?php
                                    if (isset($_SESSION['userperu'])) {
                                        echo "Hello, " . htmlspecialchars($_SESSION['userperu']) . "!";
                                    } else {
                                        echo "Hello, Guest!";
                                    }
                                    ?>
                                </div>

                                <h1 class="book-heading">BOOK A SERVICE</h1>
                                <div class="contact-info">
                                    <div class="phone-icon">
                                        <span>&#9742;</span> <!-- Phone icon -->
                                    </div>
                                    <div class="phone-number">
                                        <p>(91) 155 600 700</p>
                                    </div>
                                </div>
                                <p class="tagline">
                                    Say Goodbye to endless Google Searches For a Good Mechanic.
                                    Mechanic Master Makes Finding the Perfect Mechanic Easy and Stress-free.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>


        <section id="6Maps" style="height:100vh;padding: 50px;">
            <h1 class="mapsHeading">Maps</h1>
            <div class="map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3809.1712982226677!2d78.5060029147703!3d17.352986188090786!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1zQmhvaiBSZWRkeSBNZXRhbCwgSGVoYWRyYW4gQ29sbGVnZSwgSGVoYWRyYW4sIFRlbGFuZ2EgNTAwMDgx!5e0!3m2!1sen!2sin!4v1624235783377!5m2!1sen!2sin"
                    allowfullscreen="" loading="lazy"></iframe>
            </div>
        </section>


        <section id="7Mechanics" class="m-4">
            <h1 class="mechanicsHeading">Discover Your Mechanics</h1>
            <label for="city">Select District:</label>
            <select id="2city" onchange="filterMechanicsByCity()"
                style="width:200px;height:40px;padding:10px; margin:35px; border-radius: 10px;">
                <option value="">Select City</option>
                <option value="Hyderabad">Hyderabad</option>
                <option value="Nalgonda">Nalgonda</option>
                <option value="Nizamabad">Nizamabad</option>
                <!-- Add other cities -->
            </select>

            <div id="mechanicList" class="container-fluid mt-2" style="overflow-x: auto;">
                <div class="d-flex flex-row gap-3">
                    <?php foreach ($mechanics as $mechanic): ?>
                        <div class="mb-4" style="flex: 0 0 auto;">
                            <!-- Add data-city attribute to each mechanic card -->
                            <div class="card h-60 text-center mechanic-profile"
                                data-city="<?php echo htmlspecialchars($mechanic['city']); ?>"
                                style="min-height: 400px; width: 300px;">
                                <img src="potti.png" class="card-img-top" alt="Mechanic profile"
                                    style="height:150px;width:150px; object-fit:cover; margin: 10px auto;">
                                <div class="card-body" style="line-height: 1.2;">
                                    <h5 class="card-title">
                                        <?php echo htmlspecialchars($mechanic['name']); ?>
                                    </h5>
                                    <p class="card-text">Username:
                                        <?php echo htmlspecialchars($mechanic['username']); ?>
                                    </p>
                                    <p class="card-text"><strong>Experience:</strong>
                                        <?php echo htmlspecialchars($mechanic['exp']); ?> years
                                    </p>
                                    <p class="card-text"><strong>Contact:</strong>
                                        <?php echo htmlspecialchars($mechanic['contact']); ?>
                                    </p>
                                    <p class="card-text"><strong>City:</strong>
                                        <?php echo htmlspecialchars($mechanic['city']); ?>
                                    </p>
                                    <p class="card-text"><strong>Address:</strong>
                                        <?php echo htmlspecialchars($mechanic['address']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <script>
                function filterMechanicsByCity() {
                    var selectedCity = document.getElementById('2city').value.toLowerCase();
                    var mechanicProfiles = document.querySelectorAll('.mechanic-profile');

                    mechanicProfiles.forEach(function (profile) {
                        var city = profile.getAttribute('data-city').toLowerCase();

                        if (selectedCity === "" || selectedCity === "select city") {
                            // If no valid city is selected, hide all mechanics
                            profile.style.display = 'none';
                        } else {
                            // Show the mechanic if the city matches
                            profile.style.display = city === selectedCity ? 'flex' : 'none';
                        }
                    });
                }

                // Hide all mechanic profiles when the page loads
                document.addEventListener('DOMContentLoaded', function () {
                    var mechanicProfiles = document.querySelectorAll('.mechanic-profile');
                    mechanicProfiles.forEach(function (profile) {
                        profile.style.display = 'none'; // Hide all mechanic profiles initially
                    });
                });

            </script>
        </section>


        <section id="8Kart">
            <div class="empty"></div>
            <h1 class="kartHeading">Your One-Stop Shop for Vehicle Essentials</h1>

            <div class="KartcategoriesList">
                <div class="KartCategory" onclick="showItems('81windshield.html')">
                    <img class="81" src="../ASSETS/81PeriodicMaintainance.jpeg" alt="Services image">
                    <h2>Wind Sheilds</h2>
                </div>
                <div class="KartCategory" onclick="showItems('82suspension.html')">
                    <img class="82" src="../ASSETS/82SuspensionAndFitments.jpeg" alt="Suspension And Fitments">
                    <h2>Suspensions & Fitments</h2>
                </div>
                <div class="KartCategory" onclick="showItems('83battery.html')">
                    <img class="83" src="../ASSETS/83Battery.jpeg" alt="Battery image">
                    <h2>Batteries</h2>
                </div>
                <div class="KartCategory" onclick="showItems('84tyre.html')">
                    <img class="84" src="../ASSETS/84Tire.jpeg" alt="Tire image">
                    <h2>Tyres & Wheel Care</h2>
                </div>
                <div class="KartCategory" onclick="showItems('85Lights.html')">
                    <img class="85" src="../ASSETS/85Lights.jpeg" alt="Lights image">
                    <h2>Lights</h2>
                </div>
                <div class="KartCategory" onclick="showItems('86mirrors.html')">
                    <img class="86" src="../ASSETS/86Mirrors.jpeg" alt="Mirros image">
                    <h2>Mirrors</h2>
                </div>
                <div class="KartCategory" onclick="showItems('87clutch.html')">
                    <img class="87" src="../ASSETS/87CarClutch.jpeg" alt="Clutch image">
                    <h2>Clutch & Body parts</h2>
                </div>
                <div class="KartCategory" onclick="showItems('88cleaners.html')">
                    <img class="88" src="../ASSETS/88Cleaners.png" alt="Cleaners">
                    <h2>Cleaners</h2>
                </div>
            </div>

            <div class="KartcategoriesItems">
                <div class="placeholder"></div>
                <h2 id="defaultText">Category not yet selected</h2>
            </div>
        </section>


        <section id="8bill" class="mt-3">
            <div class="d-flex justify-content-center mt-4">
                <button class="btn btn-dark" id="billButton" onclick="generateBill()">Generate Bill</button>
            </div>
            <table class="tablex">
                <thead class="theadx">
                    <tr class="trx">
                        <th class="thx">Product ID</th>
                        <th class="thx">Product Name</th>
                        <th class="thx">Quantity</th>
                        <th class="thx">Price</th>
                        <th class="thx">Total</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                </tbody>
            </table>
        </section>

        <section id="9Fuel">
            <h1 class="mechanicsHeading">Fuel up in 10 mins! ⛽</h1>
            <div class="fuelContainer">
                <div class="d-flex flex-column mb-3">
                    <div class="p-2 g-2 d-flex justify-content-between">
                        <div class="fuelImage">
                            <span class="fuelPrice"> 107.41/- </span>
                            <img src="../ASSETS/91FuelPetrol.jpeg" alt="91 Fuel Petrol">
                        </div>
                        <div class="Fuel-controls d-flex justify-content-center mt-2">
                            <button class="btn btn-dark" onclick="decrementFuel('item91')">-</button>
                            <input class="fuel-control mx-2 text-center" type="number" id="item91" value="0" min="0"
                                max="2" step="0.5" style="width: 50px;">
                            <button class="btn btn-dark" onclick="incrementFuel('item91')">+</button>
                        </div>
                    </div>
                    <div class="p-2 d-flex justify-content-between">
                        <div class="fuelImage">
                            <span class="fuelPrice"> 96.65/- </span>
                            <img src="../ASSETS/92FuelDiesel.jpeg" alt="92 Fuel Diesel">
                        </div>
                        <div class="Fuel-controls d-flex justify-content-center mt-2">
                            <button class="btn btn-dark" onclick="decrementFuel('item92')">-</button>
                            <input class="fuel-control mx-2 text-center" type="number" id="item92" value="0" min="0"
                                max="2" step="0.5" style="width: 50px;">
                            <button class="btn btn-dark" onclick="incrementFuel('item92')">+</button>
                        </div>
                    </div>
                    <div class="p-2 d-flex justify-content-between">
                        <div class="fuelImage">
                            <span class="fuelPrice"> 96.00/- </span>
                            <img src="../ASSETS/93FuelCNG.jpeg" alt="93 Fuel CNG">
                        </div>
                        <div class="Fuel-controls d-flex justify-content-center mt-2">
                            <button class="btn btn-dark" onclick="decrementFuel('item93')">-</button>
                            <input class="fuel-control mx-2 text-center" type="number" id="item93" value="0" min="0"
                                max="2" step="0.5" style="width: 50px;">
                            <button class="btn btn-dark" onclick="incrementFuel('item93')">+</button>
                        </div>
                    </div>

                    <button class="btn btn-dark mt-3" id="fuelBillButton" onclick="calculateBill()">Get Bill</button>

                    <div id="billOutput" class="mt-3 text-center"></div>
                </div>
            </div>

            <script>
                function incrementFuel(id) {
                    let fuelInput = document.getElementById(id);
                    let currentFuelValue = parseFloat(fuelInput.value);
                    if (currentFuelValue < parseFloat(fuelInput.max)) {
                        fuelInput.value = (currentFuelValue + 0.5).toFixed(1);
                    }
                }

                function decrementFuel(id) {
                    let fuelInput = document.getElementById(id);
                    let currentFuelValue = parseFloat(fuelInput.value);
                    if (currentFuelValue > parseFloat(fuelInput.min)) {
                        fuelInput.value = (currentFuelValue - 0.5).toFixed(1);
                    }
                }

                function calculateBill() {
                    // Prices of each fuel type
                    const prices = {
                        item91: 107.41,
                        item92: 95.65,
                        item93: 96
                    };

                    // Calculate total amount
                    let totalAmount = 0;
                    totalAmount += (parseFloat(document.getElementById('item91').value) || 0) * prices.item91;
                    totalAmount += (parseFloat(document.getElementById('item92').value) || 0) * prices.item92;
                    totalAmount += (parseFloat(document.getElementById('item93').value) || 0) * prices.item93;

                    // Display the total amount
                    document.getElementById('billOutput').innerText = `Your bill is ₹${totalAmount.toFixed(2)}`;
                }
            </script>
        </section>

        <section id="10Contact">
            <div class="contact-container">
                <h2>Contact Us</h2>
                <form id="contactForm" action="https://api.web3forms.com/submit" method="POST">
                    <!-- Web3Forms API Key -->
                    <input type="hidden" name="apikey" value="1523e28e-6202-4269-a043-01a453d90655">

                    <!-- Honeypot Field for Spam Protection -->
                    <input type="text" name="bot-field" class="hidden-field" autocomplete="off">

                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Your Name" required>

                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" placeholder="e.g., 1234567890" pattern="[0-9]{10}"
                        required>

                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="5" placeholder="Your Message" required></textarea>

                    <button type="submit">Send Message</button>
                </form>
                <div id="formMessage"></div>
            </div>

            <!-- Optional: Link to external JS -->
            <script src="scripts.js"></script>

        </section>



        <section id="11Rating">
            <div class="container mb-4">
                <div class="row justify-content-center">
                    <iframe src="11rating.php" frameborder="0" id="11RatingIframe" scrolling="no"></iframe>
                </div>
            </div>
            <script>
                function resizeIframe() {
                    var iframe = document.getElementById("11RatingIframe");
                    iframe.style.height = iframe.contentWindow.document.body.scrollHeight + "px";
                }
                document.getElementById("11RatingIframe").onload = function () {
                    resizeIframe();
                };
            </script>
        </section>


        <style>
            /* Floating Circle Icon */
            .floating-icon {
                position: fixed;
                right: 20px;
                bottom: 30px;
                background-color: #FFD700;
                width: 60px;
                height: 60px;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                cursor: pointer;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
                transition: background-color 0.3s ease;
                z-index: 1001;
            }

            .floating-icon:hover {
                background-color: #e6c200;
            }

            .floating-icon img {
                width: 25px;
                height: 25px;
            }

            /* Chatbot Modal */
            .chatbot-modal {
                position: fixed;
                bottom: 100px;
                right: 20px;
                width: 350px;
                max-width: 90%;
                background-color: #1e1e1e;
                border-radius: 10px;
                box-shadow: 0 4px 20px rgba(255, 215, 0, 0.5);
                display: none;
                flex-direction: column;
                overflow: hidden;
                z-index: 1000;
            }

            /* Chat Header */
            .chat-header {
                background-color: #FFD700;
                padding: 15px;
                text-align: center;
                font-weight: bold;
                color: #1e1e1e;
                position: relative;
            }

            /* Close Button */
            .close-button {
                position: absolute;
                top: 10px;
                right: 15px;
                font-size: 1.2em;
                font-weight: bold;
                cursor: pointer;
                color: #1e1e1e;
            }

            .close-button:hover {
                color: #e6c200;
            }

            /* Chat Body */
            .chat-body {
                background-color: #2c2c2c;
                flex: 1;
                padding: 15px;
                overflow-y: auto;
            }

            /* Chat Footer */
            .chat-footer {
                padding: 10px;
                background-color: #1e1e1e;
                display: flex;
                align-items: center;
                position: relative;
            }

            /* Input Field */
            .chat-footer input {
                flex: 1;
                padding: 10px 15px;
                border: none;
                border-radius: 20px;
                font-size: 14px;
                outline: none;
                background-color: #3a3a3a;
                color: #fff;
            }

            /* Send Button */
            .chat-footer button {
                background-color: #FFD700;
                border: none;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                margin-left: 10px;
                cursor: pointer;
                display: flex;
                justify-content: center;
                align-items: center;
                transition: background-color 0.3s ease;
            }

            .chat-footer button:hover {
                background-color: #e6c200;
            }

            .chat-footer button img {
                width: 20px;
                height: 20px;
            }

            /* Chat Messages */
            .message {
                margin-bottom: 15px;
                display: flex;
            }

            .message.user {
                justify-content: flex-end;
            }

            .message.user .message-content {
                background-color: #FFD700;
                color: #1e1e1e;
                border-radius: 15px 15px 0 15px;
            }

            .message.bot {
                justify-content: flex-start;
            }

            .message.bot .message-content {
                background-color: #3a3a3a;
                color: #fff;
                border-radius: 15px 15px 15px 0;
            }

            .message-content {
                max-width: 70%;
                padding: 10px 15px;
                position: relative;
                word-wrap: break-word;
            }

            /* Suggestions Box */
            .suggestions {
                position: absolute;
                bottom: 60px;
                left: 10px;
                right: 60px;
                background-color: #2c2c2c;
                border: 1px solid #444;
                border-radius: 5px;
                max-height: 150px;
                overflow-y: auto;
                display: none;
                z-index: 1002;
            }

            .suggestions li {
                padding: 10px 15px;
                list-style: none;
                cursor: pointer;
                border-bottom: 1px solid #444;
                transition: background-color 0.2s ease;
            }

            .suggestions li:last-child {
                border-bottom: none;
            }

            .suggestions li:hover {
                background-color: #444;
            }

            /* Responsive Design */
            @media (max-width: 400px) {
                .chatbot-modal {
                    width: 90%;
                    right: 5%;
                }

                .floating-icon {
                    width: 50px;
                    height: 50px;
                }

                .floating-icon img {
                    width: 20px;
                    height: 20px;
                }
            }
        </style>
        <!-- Floating Chat Icon -->
        <div class="floating-icon" id="openChatbot" title="Chat with us">
            <img src="https://img.icons8.com/ios-filled/50/000000/chat.png" alt="Chat Icon">
        </div>

        <!-- Chatbot Modal -->
        <div class="chatbot-modal" id="chatbotModal">
            <!-- Chat Header -->
            <div class="chat-header">
                Mechanic Master
                <span class="close-button" id="closeChatbot">&times;</span>
            </div>

            <!-- Chat Body -->
            <div class="chat-body" id="chatBody">
                <!-- Initial Greeting from Bot -->
                <div class="message bot">
                    <div class="message-content">
                        Welcome to Mechanic Master! How can I assist you today?
                    </div>
                </div>
            </div>

            <!-- Suggestions Box -->
            <ul class="suggestions" id="suggestionsList">
                <!-- Suggestions will appear here -->
            </ul>

            <!-- Chat Footer -->
            <div class="chat-footer">
                <input type="text" id="userInput" placeholder="Type your message...">
                <button id="sendButton">
                    <img src="https://img.icons8.com/ios-filled/50/000000/send.png" alt="Send">
                </button>
            </div>
        </div>

        <script>
            // JavaScript Code

            // Get Elements
            const openChatbot = document.getElementById('openChatbot');
            const chatbotModal = document.getElementById('chatbotModal');
            const closeChatbot = document.getElementById('closeChatbot');
            const sendButton = document.getElementById('sendButton');
            const userInput = document.getElementById('userInput');
            const chatBody = document.getElementById('chatBody');
            const suggestionsList = document.getElementById('suggestionsList');

            // Predefined queries and responses
            const data = {
                "find a mechanic near me": "Sure! Please provide your location to find mechanics near you.",
                "hyderabad":"Mahesh - 789456123 , Prabhas - 789456123.",
                "mechanic for engine repair": "We have experienced mechanics specializing in engine repair. Would you like to book an appointment?",
                "oil change services": "Oil change services are available. Please select a convenient time for you.",
                "car battery replacement": "Car battery replacement services are ready. Do you want to schedule a service?",
                "tire alignment": "Tire alignment services are offered. Let us know your preferred time.",
                "emergency mechanic": "Emergency mechanic services are available 24/7. How can we assist you?",
                "book a mechanic": "Please provide your vehicle details and preferred date/time for booking.",
                "mechanic rates": "Our mechanic rates start at $50 per hour. Would you like more details?",
                "car diagnostics": "Car diagnostic services are available. Please bring your vehicle in for a check-up.",
                "transmission repair": "Transmission repair services are provided by our certified mechanics. Need to book?",
                "brake replacement": "Brake replacement services are available. Let us know your preferred schedule.",
                "vehicle inspection": "We offer comprehensive vehicle inspections. Would you like to book one?",
                "suspension repair": "Suspension repair services are provided by our experts. How can we help?",
                "air conditioning service": "Air conditioning services are available to keep your vehicle cool.",
                "wheel alignment": "Wheel alignment services can improve your vehicle's performance. Want to book?",
                "fuel system cleaning": "Fuel system cleaning services are available. Let us know your preferred time.",
                "exhaust system repair": "Exhaust system repair services are offered by our skilled mechanics.",
                "clutch replacement": "Clutch replacement services are ready. Do you want to schedule a service?",
                "starter motor repair": "Starter motor repair services are available. How can we assist you?",
                "car detailing": "We offer car detailing services to keep your vehicle looking new.",
                "lube services": "Lube services are available. Please choose a convenient time for you.",
                "windshield repair": "Windshield repair services are available. Would you like to book an appointment?",
                "battery testing": "Battery testing services can help determine your car's battery health.",
                "safety inspection": "Safety inspections are crucial. Schedule one with our certified mechanics.",
                "align and balance tires": "We offer tire alignment and balancing services for optimal performance.",
                "engine diagnostics": "Engine diagnostic services are available to identify and fix issues.",
                "vehicle towing": "Vehicle towing services are available in case of breakdowns. Need assistance?",
                "radiator repair": "Radiator repair services are provided to keep your engine cool.",
                "fuel injection services": "Fuel injection services are available to improve your vehicle's efficiency.",
                "oil leak repair": "Oil leak repair services are ready. Would you like to schedule a service?",
                "timing belt replacement": "Timing belt replacement services are essential for engine health.",
                "power steering repair": "Power steering repair services are available. Let us know your preferred time.",
                "car upholstery cleaning": "We offer car upholstery cleaning to keep your interior spotless.",
                "air filter replacement": "Air filter replacement services are available for better engine performance.",
                "cooling system repair": "Cooling system repair services are provided to prevent overheating.",
                "exhaust pipe replacement": "Exhaust pipe replacement services are ready. Do you want to book?",
                "spark plug replacement": "Spark plug replacement services are available for optimal engine performance."
                // Add more queries and responses as needed
            };

            // Extract keys for suggestions
            const queries = Object.keys(data);

            // Function to display suggestions
            function showSuggestions(value) {
                suggestionsList.innerHTML = '';
                if (value.length === 0) {
                    suggestionsList.style.display = 'none';
                    return;
                }
                const filtered = queries.filter(query => query.toLowerCase().includes(value.toLowerCase()));
                if (filtered.length === 0) {
                    suggestionsList.style.display = 'none';
                    return;
                }
                filtered.forEach(query => {
                    const li = document.createElement('li');
                    li.textContent = query;
                    li.addEventListener('click', () => {
                        userInput.value = query;
                        suggestionsList.style.display = 'none';
                        sendMessage(query);
                    });
                    suggestionsList.appendChild(li);
                });
                suggestionsList.style.display = 'block';
            }

            // Function to append message to chat
            function appendMessage(content, sender) {
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('message', sender);

                const messageContent = document.createElement('div');
                messageContent.classList.add('message-content');
                messageContent.textContent = content;

                messageDiv.appendChild(messageContent);
                chatBody.appendChild(messageDiv);
                chatBody.scrollTop = chatBody.scrollHeight;
            }

            // Function to handle user message
            function sendMessage(message) {
                if (message.trim() === '') return;
                appendMessage(message, 'user');
                userInput.value = '';
                suggestionsList.style.display = 'none';
                respond(message);
            }

            // Function to respond to user message
            function respond(message) {
                const response = data[message.toLowerCase()] || "I'm sorry, I don't understand that. Can you please rephrase?";
                // Simulate bot typing delay
                setTimeout(() => {
                    appendMessage(response, 'bot');
                }, 1000);
            }

            // Function to initialize chat with greeting
            function initializeChat() {
                chatBody.innerHTML = ''; // Clear previous messages
                appendMessage("Welcome to Mechanic Master! How can I assist you today?", 'bot');
            }

            // Event listeners

            // Open chatbot
            openChatbot.addEventListener('click', () => {
                chatbotModal.style.display = 'flex';
                initializeChat();
                userInput.focus();
            });

            // Close chatbot
            closeChatbot.addEventListener('click', () => {
                chatbotModal.style.display = 'none';
                suggestionsList.style.display = 'none';
            });

            // Close chatbot when clicking outside
            window.addEventListener('click', (e) => {
                if (!chatbotModal.contains(e.target) && !openChatbot.contains(e.target)) {
                    chatbotModal.style.display = 'none';
                    suggestionsList.style.display = 'none';
                }
            });

            // Send message on button click
            sendButton.addEventListener('click', () => {
                const message = userInput.value;
                sendMessage(message);
            });

            // Send message on Enter key press
            userInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    const message = userInput.value;
                    sendMessage(message);
                }
            });

            // Show suggestions as user types
            userInput.addEventListener('input', (e) => {
                showSuggestions(e.target.value);
            });

            // Close suggestions when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.chatbot-modal') && !e.target.closest('.floating-icon')) {
                    suggestionsList.style.display = 'none';
                }
            });
        </script>


    </main>

    <footer>
        <p class="p-4 text-center">&copy; 2024 Mechanic Finder. All rights reserved.</p>
    </footer>

    <script src="../JAVASCRIPT/8KartScript.js"></script>
    <script src="../JAVASCRIPT/83battery.js"></script>
    <!-- <script src="../JAVASCRIPT/11Rating.js"></script> -->
</body>

</html>