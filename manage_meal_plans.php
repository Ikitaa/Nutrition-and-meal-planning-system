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

        $query = "INSERT INTO meal_plans (meal_category, meal_description, photo_url,
         age_group, weight_goal_id, diet_id, disease_id) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'sssiiss', $category, $description, $photo_url,
         $age_group, $weight_goal_id, $diet_id, $disease_id);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            display: flex;
            transition: margin-left 0.3s;
            height: 100vh;
        }

        /* Header Styling */
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

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #f4f4f4;
            padding: 20px;
            position: fixed;
            top: 70px;
            left: 0;
            height: calc(100vh - 70px);
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: width 0.3s;
        }

        .sidebar h2 {
            color: #28a745;
            margin-top: 0;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            margin: 10px 0;
            border-radius: 4px;
            background-color: #fff;
            transition: background-color 0.3s;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 18px;
        }

        .sidebar a:hover {
            background-color: #28a745;
            color: #fff;
        }
        .container {
        margin-left: 280px; /* To leave space for the sidebar */
            margin-top: 120px;
            padding: 20px;
        }

        .container h2 {
            text-align: center;
        }

        .btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #218838;
        }

        /* Table Styling */
        table {
            width: 100%; 
            margin: 30px 0;
            border-collapse: collapse;
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

        /* Button Styles */
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
        <div class="logo">
            <a href="admin_dashboard.php">
                <img src="logo.png" alt="Smart Diet Logo"> SmartDiet
            </a>
        </div>
    </header>

    <div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="view_users.php"><i class="fas fa-users"></i> View Users</a>
    <a href="manage_meal_plans.php"><i class="fas fa-utensils"></i> Manage Meal Plans</a>
    <a href="grocery_admin.php"><i class="fas fa-list-alt"></i> Grocery List</a>
    <a href="order_admin.php"><i class="fas fa-box-open"></i> Manage Orders</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>
<div class="container">
    <h2>Registered Meal Plans</h2>
    <a href="add_meal.php" class="btn">Add Meal Plan</a>

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
</div>

</body>
</html>
