<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartdiet";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$meal_id = $_POST['meal_id']; // Assume meal_id is passed from the form
$meal_category = $_POST['meal_category']; // Assume meal_category is passed from the form
$meal_description = $_POST['meal_description']; // Assume meal_description is passed from the form

// Retrieve meal plan details
$query = "SELECT diet_id, disease_id, weight_goal_id FROM meal_plans WHERE meal_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $meal_id);
$stmt->execute();
$stmt->bind_result($diet_id, $disease_id, $weight_goal_id);
$stmt->fetch();
$stmt->close();

// Now update the user_meal_plan table
$update_query = "UPDATE user_meal_plan 
                 SET meal_category = ?, meal_description = ?, photo_url = ? 
                 WHERE user_id = ? AND meal_id = ?";
$stmt = $conn->prepare($update_query);
$stmt->bind_param("sssii", $meal_category, $meal_description, $photo_url, $user_id, $meal_id);

if ($stmt->execute()) {
    echo "Meal plan updated successfully!";
    header("Location: dashboard.php"); // Redirect to dashboard after update
} else {
    echo "Error updating record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
