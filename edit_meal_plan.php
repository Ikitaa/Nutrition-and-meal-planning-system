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

// Fetch the meal plan details for editing
if (isset($_GET['meal_id'])) {
    $meal_id = $_GET['meal_id'];
    $query = "SELECT * FROM meal_plans WHERE meal_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $meal_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $meal = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$meal) {
        echo "Meal not found.";
        exit;
    }
}

// Check if the form for editing was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $meal_id = $_POST['meal_id'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $photo_url = $_POST['photo_url'];
    $age_group = $_POST['age_group'];
    $weight_goal_id = $_POST['weight_goal_id'];
    $diet_id = $_POST['diet_id'];
    $disease_id = $_POST['disease_id'];

    $query = "UPDATE meal_plans SET meal_category = ?, meal_description = ?, photo_url = ?, age_group = ?, weight_goal_id = ?, diet_id = ?, disease_id = ? WHERE meal_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssiiisi', $category, $description, $photo_url, $age_group, $weight_goal_id, $diet_id, $disease_id, $meal_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "Meal Plan updated successfully.";
    header("Location: manage_meal_plans.php");
    exit;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - Edit MealPlan</title>
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
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
            text-decoration: none;
        }
        .logo-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            text-decoration: none;
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


h1 {
    margin: 0;
    color: #28a745;
}

.meal-form {
    
    background-color: white;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    width: 50%;
    margin: 0 auto;
    margin-top: 50px;

}

.meal-form h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #28a745;
}

.meal-form input, .meal-form select, .meal-form textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
}

.meal-form textarea {
    resize: vertical;
    height: 120px;
}

.meal-form button {
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.meal-form button:hover {
    background-color: #218838;
}

.meal-form input[type="number"] {
    -moz-appearance: textfield;
}

.meal-form input[type="number"]::-webkit-outer-spin-button,
.meal-form input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Center the form container */
.meal-form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

a {
    text-decoration: none;
    color: #28a745;
}

a:hover {
    text-decoration: underline;
}

button {
    font-size: 16px;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    background-color: #28a745;
    color: white;
    border: none;
}

button:hover {
    background-color: #218838;
}

    </style>
</head>
<body>
    <header>
        <div class="logo-container">
            <div class="logo">
                <a href="view_users.php">
                    <img src="logo.png" alt="Smart Diet Logo"> SmartDiet
                </a>
            </div>
        </div>
    </header>
<div class="meal-form">
    <h2>Edit Meal Plan</h2>
    <form action="edit_meal_plan.php" method="POST">
        <input type="hidden" name="meal_id" value="<?= htmlspecialchars($meal['meal_id']) ?>">
        <input type="text" name="category" value="<?= htmlspecialchars($meal['meal_category']) ?>" placeholder="Meal Category" required>
        <textarea name="description" placeholder="Meal Description" required><?= htmlspecialchars($meal['meal_description']) ?></textarea>
        <input type="text" name="photo_url" value="<?= htmlspecialchars($meal['photo_url']) ?>" placeholder="Photo URL" required>
        <input type="text" name="age_group" value="<?= htmlspecialchars($meal['age_group']) ?>" placeholder="Age Group" required>
        <input type="number" name="weight_goal_id" value="<?= htmlspecialchars($meal['weight_goal_id']) ?>" placeholder="Weight Goal ID" required>
        <input type="number" name="diet_id" value="<?= htmlspecialchars($meal['diet_id']) ?>" placeholder="Diet ID" required>
        <input type="number" name="disease_id" value="<?= htmlspecialchars($meal['disease_id']) ?>" placeholder="Disease ID" required>
        <button type="submit">Update Meal</button>
    </form>
</div>

</body>
</html>
