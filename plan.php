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

// Initialize current meal plan
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - MealPlan</title>
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            padding-top: 30px; /* Ensure content starts below the fixed header */
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
        .header-container {
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
            gap: 50px;
            flex-wrap: nowrap;
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
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }
        .meal img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
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
        .edit-meal-btn {
            background-color: #007bff;
            color: white;
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .edit-meal-btn:hover {
            background-color: #0056b3;
        }
        .update-form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        .update-form form {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        .update-form button {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .update-form button:hover {
            background-color: #45a049;
        }
        .update-form button:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <a href="dashboard.php">
                    <img src="logo.png" alt="Smart Diet Logo">SmartDiet
                </a>
            </div>
        </div>
    </header>

    <main>
        <div class="meal-container">
            <!-- Edit Meal Plan Button -->
            <div style="text-align: left; margin-bottom: 20px;">
                <a href="edit_meal_plan.php">
                    <button class="edit-meal-btn">Edit Meal Plan</button>
                </a>
            </div>
            
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
    </main>
</body>
</html>
