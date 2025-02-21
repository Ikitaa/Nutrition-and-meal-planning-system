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

// Check if a form for adding or deleting a meal plan was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add new meal plan
    if (isset($_POST['add_meal'])) {
        $category = $_POST['category'];
        $description = $_POST['description'];
        $photo_url = $_POST['photo_url'];
        $age_group = $_POST['age_group'];
        $weight_goal_id = $_POST['weight_goal_id'];
        $diet_id = $_POST['diet_id'];
        $disease_id = $_POST['disease_id'];

        $query = "INSERT INTO meal_plans (meal_category, meal_description, photo_url, age_group, weight_goal_id, diet_id, disease_id) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'sssiiss', $category, $description, $photo_url, $age_group, $weight_goal_id, $diet_id, $disease_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "Meal Plan added successfully.";
    }

    // Delete meal plan
    if (isset($_POST['delete_meal'])) {
        $meal_id = $_POST['meal_id'];

        $query = "DELETE FROM meal_plans WHERE meal_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $meal_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "Meal Plan deleted successfully.";
    }
}

// Fetch meal plans from the database
$query = "SELECT * FROM meal_plans ORDER BY meal_category";
$result = mysqli_query($conn, $query);
$meal_plans = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - MealPlan</title>
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #28a745;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        header img {
            height: 40px; /* Adjust logo height */
            margin-right: 10px; /* Add space between the logo and text */
        }
        h1 {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #28a745;
            color: white;
        }
        td {
            text-align: center;
        }
        td img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
        .meal-form {
            margin-top: 30px;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 50%;
            margin: 0 auto;
        }
        .meal-form input, .meal-form select, .meal-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .meal-form button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .meal-form button:hover {
            background-color: #218838;
        }
        /* Edit Button - Red */
.edit-button {
    padding: 8px 15px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.edit-button:hover {
    background-color: #c82333;
}

/* Delete Button - Green */
.delete-button {
    padding: 8px 15px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.delete-button:hover {
    background-color: #218838;
}

    </style>
</head>
<body>
    <header>
        <img src="logo.png" alt="Smart Diet Logo"> SmartDiet- Manage MealPlan
    </header>

<table>
    <thead>
        <tr>
            <th>Meal ID</th>
            <th>Age Group</th>
            <th>Weight Goal ID</th>
            <th>Diet ID</th>
            <th>Disease ID</th>
            <th>Meal Category</th>
            <th>Meal Description</th>
            <th>Photo</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($meal_plans as $meal): ?>
            <tr>
                <td><?= htmlspecialchars($meal['meal_id']) ?></td>
                <td><?= htmlspecialchars($meal['age_group']) ?></td>
                <td><?= htmlspecialchars($meal['weight_goal_id']) ?></td>
                <td><?= htmlspecialchars($meal['diet_id']) ?></td>
                <td><?= htmlspecialchars($meal['disease_id']) ?></td>
                <td><?= htmlspecialchars($meal['meal_category']) ?></td>
                <td><?= htmlspecialchars($meal['meal_description']) ?></td>
                <td><img src="meals/<?= htmlspecialchars($meal['photo_url']) ?>" alt="Meal Image"></td>
                <td>
                    <!-- Edit Meal Button (links to edit_meal_plan.php) -->
                    <a href="edit_meal_plan.php?meal_id=<?= $meal['meal_id'] ?>">
                    <button class="edit-button">Edit</button>
                    </a>
                    <!-- Delete Meal Button -->
                    <form action="manage_meal_plans.php" method="POST" style="display:inline;">
                        <input type="hidden" name="meal_id" value="<?= $meal['meal_id'] ?>">
                        <button type="submit" name="delete_meal" class="delete-button">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Add New Meal Form -->
<div class="meal-form">
    <h2>Add New Meal Plan</h2>
    <form action="manage_meal_plans.php" method="POST">
        <input type="text" name="category" placeholder="Meal Category" required>
        <textarea name="description" placeholder="Meal Description" required></textarea>
        <input type="text" name="photo_url" placeholder="Photo URL" required>
        <input type="text" name="age_group" placeholder="Age Group" required>
        <input type="number" name="weight_goal_id" placeholder="Weight Goal ID" required>
        <input type="number" name="diet_id" placeholder="Diet ID" required>
        <input type="number" name="disease_id" placeholder="Disease ID" required>
        <button type="submit" name="add_meal">Add Meal</button>
    </form>
</div>

</body>
</html>
