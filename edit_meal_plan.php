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

// Fetch user details including age
$user_query = "SELECT TIMESTAMPDIFF(YEAR, dateofbirth, CURDATE()) AS age, dateofbirth FROM register WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
$age = $user['age']; // Exact user age

// Fetch the user's meal plan
$sql = "SELECT ump.id, mp.weight_goal_id, mp.diet_id, mp.disease_id, ump.meal_id, 
               mp.meal_category, mp.meal_description
        FROM user_meal_plan ump
        JOIN meal_plans mp ON ump.meal_id = mp.meal_id
        WHERE ump.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$meal = $result->fetch_assoc();

if (!$meal) {
    die("No meal plan found for this user.");
}

// Fetch dropdown options
$weight_goals = $conn->query("SELECT * FROM weight_goals");
$diets = $conn->query("SELECT * FROM dietary_preferences");
$diseases = $conn->query("SELECT * FROM diseases");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Meal Plan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background: #f4f4f4;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px gray;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Your Meal Plan</h2>
    <form action="edit_meal_plan_process.php" method="POST">
        <input type="hidden" name="user_meal_plan_id" value="<?= $meal['id'] ?>">
        <input type="hidden" name="meal_id" value="<?= $meal['meal_id'] ?>">
        <label>Age:</label>
        <input type="number" name="age" value="<?= $age ?>" required>

        <label>Weight Goal:</label>
        <select name="weight_goal_id">
            <?php while ($row = $weight_goals->fetch_assoc()): ?>
                <option value="<?= $row['weight_goal_id'] ?>" <?= ($meal['weight_goal_id'] == $row['weight_goal_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['goal_name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Dietary Preference:</label>
        <select name="diet_id">
            <?php while ($row = $diets->fetch_assoc()): ?>
                <option value="<?= $row['diet_id'] ?>" <?= ($meal['diet_id'] == $row['diet_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['diet_name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Disease:</label>
        <select name="disease_id">
            <?php while ($row = $diseases->fetch_assoc()): ?>
                <option value="<?= $row['disease_id'] ?>" <?= ($meal['disease_id'] == $row['disease_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['disease_name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Update Meal Plan</button>
    </form>
</div>

</body>
</html>
