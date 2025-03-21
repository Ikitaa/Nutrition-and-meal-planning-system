<?php
$connection = new mysqli('localhost', 'root', '', 'smartdiet');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $age_group = $_POST['age_group'];
    $weight_goal_id = $_POST['weight_goal_id'];
    $disease_id = $_POST['disease_id'];
    $diet_id = $_POST['diet_id'];
    $meal_category = $_POST['meal_category'];
    $meal_description = $_POST['meal_description'];
    $photo_url = $_POST['photo_url']; // Optional: if you want to allow meal images

    // Prepare and bind
    $stmt = $connection->prepare("INSERT INTO meal_plans (age_group, weight_goal_id, disease_id, diet_id, meal_category, meal_description, photo_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiisss", $age_group, $weight_goal_id, $disease_id, $diet_id, $meal_category, $meal_description, $photo_url);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Meal plan added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Meal Plan</title>
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
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

        h1, h2 {
            text-align: center;
            color: #28a745;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        td:first-child {
            font-weight: bold;
            text-align: right;
            width: 30%;
        }

        input, select, textarea, button {
            width: calc(100% - 20px);
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
        }

        button:hover {
            background-color: #1e7e34;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo-container">
            <div class="logo">
                <a href="manage_meal_plans.php">
                    <img src="logo.png" alt="SmartDiet Logo"> SmartDiet
                </a>
            </div>
        </div>
    </header>
    <div class="container">
        <h2>Add Meal Plan</h2>

        <!-- Meal plan form -->
        <form action="add_meal.php" method="post">
            <table>
                <tr>
                    <td>Age Group:</td>
                    <td><input type="text" name="age_group" required></td>
                </tr>
                <tr>
                    <td>Weight Goal ID:</td>
                    <td><input type="number" name="weight_goal_id" required></td>
                </tr>
                <tr>
                    <td>Disease ID:</td>
                    <td><input type="number" name="disease_id" required></td>
                </tr>
                <tr>
                    <td>Diet ID:</td>
                    <td><input type="number" name="diet_id" required></td>
                </tr>
                <tr>
                    <td>Meal Category (Breakfast, Lunch, Dinner):</td>
                    <td><input type="text" name="meal_category" required></td>
                </tr>
                <tr>
                    <td>Meal Description:</td>
                    <td><textarea name="meal_description" required></textarea></td>
                </tr>
                <tr>
                    <td>Meal Photo URL (optional):</td>
                    <td><input type="text" name="photo_url"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <button type="submit">Add Meal Plan</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
