<?php
// Database configuration
$host = 'localhost';
$dbname = 'smartdiet';
$username = 'root';
$password = '';

// Connect to the database
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Validate form data on server-side
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form inputs
    $age = $_POST['age'] ?? null;
    $weight_goal = strtolower(trim($_POST['weight'] ?? ''));
    $diet = strtolower(trim($_POST['diet'] ?? ''));
    $disease = strtolower(trim($_POST['disease'] ?? ''));

    // Mapping for weight goals
    $weight_goal_map = [
        'loss' => 'Weight Loss',
        'gain' => 'Weight Gain',
        'maintain' => 'Maintain Weight',
    ];

    // Normalize inputs
    if (isset($weight_goal_map[$weight_goal])) {
        $weight_goal = $weight_goal_map[$weight_goal];
    } else {
        die("Invalid weight goal selected. Submitted value: $weight_goal");
    }

    $diet_map = [
        'anything' => 'Anything',
        'vegetarian' => 'Vegetarian',
        'non-vegetarian' => 'Non-Vegetarian',
    ];

    $disease_map = [
        'none' => 'None',
        'hypertension' => 'Hypertension',
        'gastritis' => 'Gastritis',
        'diabetes' => 'Diabetes',
    ];

    // Normalize diet and disease
    $diet = $diet_map[$diet] ?? die("Invalid diet selected.");
    $disease = $disease_map[$disease] ?? die("Invalid disease selected.");

    // Determine age group
    if ($age >= 13 && $age <= 19) {
        $age_group = '13-19';
    } elseif ($age >= 20 && $age <= 40) {
        $age_group = '20-40';
    } elseif ($age >= 41 && $age <= 55) {
        $age_group = '41-55';
    } else {
        $age_group = '55+';
    }

    // Fetch meal plan from database
    $query = "
        SELECT meal_id, meal_category, meal_description, photo_url
        FROM meal_plans
        WHERE age_group = ?
          AND weight_goal_id = (SELECT weight_goal_id FROM weight_goals WHERE goal_name = ?)
          AND diet_id = (SELECT diet_id FROM dietary_preferences WHERE diet_name = ?)
          AND disease_id = (SELECT disease_id FROM diseases WHERE disease_name = ?)
        ORDER BY meal_category
    ";

    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'ssss', $age_group, $weight_goal, $diet, $disease);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $meal_plans = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $meal_plans[] = $row;
    }

    mysqli_stmt_close($stmt);

   session_start();
   if (!isset($_SESSION['user_id'])) {
    die("Error: User is not logged in.");
}
$user_id = $_SESSION['user_id']; 

// Check if user exists in the database
$query = "SELECT id FROM register WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    die("Error: User ID does not exist in the register table.");
}

// Now proceed with meal plan insertion
if (!empty($meal_plans)) {
    $insert_query = "INSERT INTO user_meal_plan (user_id, meal_id, meal_category, meal_description, photo_url) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);
    
    if (!$stmt) {
        die("Failed to prepare insert statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'iisss', $user_id, $meal_id, $meal_category, $meal_description, $photo_url);

    foreach ($meal_plans as $meal) {
        $meal_id = $meal['meal_id']; 
        $meal_category = $meal['meal_category'];
        $meal_description = $meal['meal_description'];
        $photo_url = $meal['photo_url'];

        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    echo "Meal plans saved successfully!";
}
} else {
    die("Invalid request.");
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet</title>
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', Arial, sans-serif;
        }
        body {
        background-color:rgb(221, 240, 215); 
        color: white; 
        font-family: 'Poppins',Arial, sans-serif;
        margin: 0;
        padding: 0;
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
        .logo-container {
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
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        margin-bottom: 20px;
        }

        .meal {
        margin: 2px; /* Reduced gap between meals */
        text-align: center;
        width: 30%; /* Increased width for larger images */
        padding: 10px;
        }

     .meal img {
    width: 100%; /* Ensure image matches container width */
    max-width: 250px; /* Increased max width */
    height: 250px; /* Increased height */
    object-fit: cover; /* Ensures the image fits within defined dimensions */
    border-radius: 10px;
    margin-bottom: 10px;
    }

    .mealplan {
        margin-top: 100px;
        padding: 0 15px;
        
    }
    .meal h3 {
        color: #333;
        font-size: 1.2em;
        margin: 10px 0;
    }

    .meal p {
        color: black;
        font-size: 1em;
    }
    h2 {
        text-align: center;
        color: #28a745;
        margin-bottom: 20px;
    }

    .breakfast-lunch-dinner-container {
        display: flex;
        justify-content: space-around;
        width: 100%;
        margin-bottom: 20px;
    }

    .buttons-container {
        display: flex;
        justify-content: center;
        gap: 10px;
        width: 100%;
        margin-top: 20px;
        padding: 0 15px;
    }

    .button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1em;
        text-align: center;
    }


    .button:hover {
        background-color: #45a049;
    }
    </style>
    <link rel="icon" href="logo.png" type="image/png">
</head>
<body>
    <header>
        <div class="logo-container">
            <div class="logo">
                <a href="#">
                    <img src="logo.png" alt="Smart Diet Logo"> SmartDiet
                </a>
            </div>
        </div>
    </header>
    <div class="mealplan">
    <h2>Your Personalized Meal Plan</h2>
    <?php if (!empty($meal_plans)): ?>
        <div class="breakfast-lunch-dinner-container">
            <?php 
            $categories = ['Breakfast', 'Lunch', 'Dinner']; 
            foreach ($categories as $category):
                foreach ($meal_plans as $meal):
                    if ($meal['meal_category'] == $category):
            ?>
                        <div class="meal">
                            <h3><?= htmlspecialchars($meal['meal_category']) ?></h3>
                            <img src="meals/<?= htmlspecialchars($meal['photo_url']) ?>" alt="Meal Image">
                            <p><?= htmlspecialchars($meal['meal_description']) ?></p>
                        </div>
            <?php
                    endif;
                endforeach;
            endforeach;
            ?>
        </div>
    <?php else: ?>
        <p>No meal plans found for the selected criteria. Please check your inputs.</p>
    <?php endif; ?>
    <div class="buttons-container">
        <button class="button" onclick="window.location.href='dashboard.php'">Go to Dashboard</button>
        <button class="button" onclick="window.location.href='grocery_page.php'">Grocery</button>
    </div>
    </div>
</body>
</html>
