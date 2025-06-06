<?php
session_start();

$host = 'localhost';
$dbname = 'smartdiet';
$username = 'root';
$password = '';

// Connect to the database
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}

$user_id = $_SESSION['user_id'];

// Get data from the form
$weight_goal_id = $_POST['weight_goal_id'];
$diet_id = $_POST['diet_id'];
$disease_id = $_POST['disease_id'];
$new_age = $_POST['age']; // Get the new age from the form

// Update the user's birthdate in the register table (if needed)
$update_age_query = "UPDATE register SET dateofbirth = DATE_SUB(CURDATE(), INTERVAL ? YEAR) WHERE id = ?";
$stmt_update_age = $conn->prepare($update_age_query);
$stmt_update_age->bind_param("ii", $new_age, $user_id);
$stmt_update_age->execute();
$stmt_update_age->close();

// Fetch meal plans from meal_plans using selected conditions
$meal_plan_query = "SELECT meal_id, meal_category, meal_description, photo_url 
                    FROM meal_plans 
                    WHERE weight_goal_id = ? AND diet_id = ? AND disease_id = ?";

$stmt = $conn->prepare($meal_plan_query);
$stmt->bind_param("iii", $weight_goal_id, $diet_id, $disease_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($meal = $result->fetch_assoc()) {
        $meal_id = $meal['meal_id'];
        $meal_category = $meal['meal_category'];
        $meal_description = $meal['meal_description'];
        $photo_url = $meal['photo_url'];

        // Update user_meal_plan with new meal details
        $update_query = "UPDATE user_meal_plan 
                         SET meal_id = ?, meal_category = ?, meal_description = ?, photo_url = ? 
                         WHERE user_id = ? AND meal_category = ?";

        $stmt_update = $conn->prepare($update_query);
        $stmt_update->bind_param("isssis", $meal_id, $meal_category, $meal_description, $photo_url, $user_id, $meal_category);
        $stmt_update->execute();
        $stmt_update->close();
    }
} else {
    echo "No matching meal plans found.";
}

$stmt->close();
$conn->close();

// Redirect to the plan page with a status message
header("Location: plan.php?status=updated");
exit();
?>
