<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartdiet";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user meal plans
$query = "SELECT ump.meal_id, mp.meal_category, mp.meal_description, mp.photo_url 
          FROM user_meal_plan ump
          JOIN meal_plans mp ON ump.meal_id = mp.meal_id
          WHERE ump.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$meals = [];
while ($row = $result->fetch_assoc()) {
    $meals[$row['meal_category']] = $row; // Categorizing meals
}

$stmt->close();
$conn->close();
// Example health insights data
$health_data = [
    'Hydration' => 8, // Glasses of water per day
    'Exercise' => 30, // Minutes of exercise per day
    'Sleep' => 7, // Hours of sleep per night
    'Fruits/Vegetables' => 5, // Servings of fruits/vegetables per day
    'Processed Foods' => 2, // Servings of processed food per day
];

// Encode the data into JSON format for use in the frontend
$health_data_json = json_encode($health_data);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet</title>
    <link rel="icon" href="logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
         body {
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
         }
         header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
            box-sizing: border-box;
         }
         .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
         }
         .logo a {
            text-decoration: none;
            font-size: 32px;
            font-weight: 600;
            color: #28a745;
            display: flex;
            align-items: center;
         }
         .logo img {
            height: 40px;
            margin-right: 10px;
         }
         nav .menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 20px;
         }
         nav .menu li {
            position: relative;
         }
         nav .menu li a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
            padding: 8px 12px;
            transition: color 0.3s ease;
            white-space: nowrap;
         }
         nav .menu li a:hover,
         nav .menu li a.active {
            color: #28a745;
         }
         nav .menu li ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            list-style: none;
            padding: 0;
            margin: 0;
            background: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
         }
         nav .menu li:hover ul {
            display: block;
         }
         nav .menu li ul li {
            padding: 10px 15px;
         }
         nav .menu li ul li a {
            white-space: nowrap;
         }

         /* Profile & Cart Section */
         .header-icons {
            display: flex;
            align-items: center;
            gap: 30px;
         }

         /* Profile */
         .profile {
            position: relative;
            display: flex;
            align-items: center;
            cursor: pointer;
         }
         .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
         }
         .profile-menu {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            background: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            list-style: none;
            padding: 10px 0;
            width: 150px;
            border-radius: 5px;
         }
         .profile:hover .profile-menu {
            display: block;
         }
         .profile-menu li {
            padding: 10px;
            text-align: center;
         }
         .profile-menu li a {
            text-decoration: none;
            color: #333;
            display: block;
            transition: 0.3s;
         }
         .profile-menu li a:hover {
            background: #28a745;
            color: white;
         }

         /* Cart */
         .cart {
            position: relative;
            cursor: pointer;
         }
         .cart img {
            width: 35px;
            height: 35px;
         }
         .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: red;
            color: white;
            font-size: 14px;
            font-weight: bold;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
         }
         .image {
    position: relative;
    width: 100%;
    height: 600px; /* Increased height */
    overflow: hidden;
}

.image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: blur(4px);
}

.image p {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 50px; /* Increased font size */
    font-weight: bold;
    color: white;
    margin-top: 20px;
}
.meal-container {
    max-width: 1000px;
    margin: 50px auto;
    padding: 20px;
    text-align: center;
}

.meal-container h2 {
    font-size: 28px;
    color: black;
    margin-bottom: 20px;
}

.meal-row {
    display: flex;
    justify-content: space-around;
    gap: 20px;
    flex-wrap: wrap;
}

.meal {
    flex: 1;
    min-width: 300px;
    background: white;
    border: 2px solid #28a745;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.1);
}

.meal h3 {
    font-size: 22px;
    color: #333;
    margin-bottom: 10px;
}

.meal p {
    font-size: 16px;
    color: #555;
}

.meal img {
    width: 100%; /* Make the image fill the width of its container */
    height: 200px; /* Set a fixed height for the image */
    object-fit: contain; /* Ensure the image maintains its aspect ratio */
    border-radius: 8px;
    margin-top: 10px;
}


.no-plan {
    color: red;
    font-weight: bold;
}
.scroll-section {
            padding: 50px;
            background-color: #f8f9fa;
            text-align: center;
            font-size: 24px;
            color: #333;
         }
/* Health Insights Graph Styling */
/* Adjust the meal-graph container */
.meal-graph {
    width: 80%; /* Make the graph container wider */
    margin: 40px auto; /* Center it */
    text-align: center;
}

/* Increase the size of the canvas */
#healthInsightsChart {
    max-width: 100%; /* Make the chart responsive */
    height: 400px; /* Increase the height for better visibility */
    margin: 0 auto; /* Center the canvas */
}

/* Center the title of the health insights */
.meal-graph h2 {
    font-size: 32px; /* Increase the font size */
    color: black;
    margin-bottom: 20px;
}


    </style>
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <a href="dashboard.php">
                <img src="logo.png" alt="Smart Diet Logo"> SmartDiet
            </a>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="plan.php">Your Plan</a></li>
                <li><a href="Grocery.php">Grocery</a></li>
                <li><a href="Order.php">Order Details</a></li>
            </ul>
        </nav>
        <div class="header-icons">
    <!-- Cart Icon -->
    <div class="cart">
        <a href="view_cart.php">
            <i class="fa fa-shopping-cart" style="font-size: 28px; color: #28a745;"></i> <!-- Dynamic cart count -->
        </a>
    </div>

    <!-- Profile Icon (Direct Link) -->
    <div class="profile">
        <a href="profile.php">
            <i class="fa fa-user-circle" style="font-size: 32px; color: #28a745;"></i>
        </a>
    </div>
    <div class="profile">
                <a href="logout_dashboard.php">
                    <i class="fa fa-sign-out-alt" style="font-size: 32px; color: #28a745;"></i>
                </a>
            </div>
</div>
    </div>
</header>
<div class="image">
    <img src="img/dash.webp" >
                <p>Welcome to SmartDiet</p>
            </div>
        </div>
        <div class="scroll-section">
    <h2>Explore Your Diet Plans</h2>
    <p>Get personalized meal recommendations tailored to your health goals.</p>
</div>
        <div class="meal-container">
    <h2>Your Meal Plan</h2>
    <div class="meal-row">
        <?php
        $categories = ['Breakfast', 'Lunch', 'Dinner'];
        foreach ($categories as $category) {
            echo "<div class='meal'>";
            echo "<h3>" . htmlspecialchars($category) . "</h3>";
            if (isset($meals[$category])) {
                echo "<p>" . htmlspecialchars($meals[$category]['meal_description']) . "</p>";
                if (!empty($meals[$category]['photo_url'])) {
                    echo "<img src='meals/" . htmlspecialchars($meals[$category]['photo_url']) . "' alt='$category Meal'>";
                }
            } else {
                echo "<p class='no-plan'>No $category meal plan available.</p>";
            }
            echo "</div>";
        }
        ?>
    </div>
</div>
<!-- Health Insights Graph Section -->
<div class="meal-graph">
    <h2>Your Health Insights</h2>
    <canvas id="healthInsightsChart" width="400" height="200"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Fetch the health data passed from the PHP backend
    var healthData = <?php echo $health_data_json; ?>;

    // Prepare data for Chart.js
    var categories = Object.keys(healthData);
    var values = Object.values(healthData);

    // Create the Chart.js graph
    var ctx = document.getElementById('healthInsightsChart').getContext('2d');
    var healthInsightsChart = new Chart(ctx, {
        type: 'bar', // Bar chart type
        data: {
            labels: categories, // Categories like Hydration, Exercise, etc.
            datasets: [{
                label: 'Health Insights',
                data: values, // Data values for each category
                backgroundColor: 'rgba(40, 167, 69, 0.7)', // Green color for the bars
                borderColor: 'rgba(40, 167, 69, 1)', // Dark green for the borders
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 10 // Maximum value for visual clarity (adjust as needed)
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
</script>

</div>
</body>
</html>

<?php
require_once 'foot.php';
?>