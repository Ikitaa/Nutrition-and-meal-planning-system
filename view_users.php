<?php
// Database connection
$connection = new mysqli('localhost', 'root', '', 'smartdiet');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Delete operation
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    // Delete related records in user_meal_plan table first
    $deleteUserMealPlanQuery = "DELETE FROM user_meal_plan WHERE user_id = ?";
    $stmt = $connection->prepare($deleteUserMealPlanQuery);
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->close();

    // Now delete the user from the register table
    $deleteQuery = "DELETE FROM register WHERE id = ?";
    $stmt = $connection->prepare($deleteQuery);
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->close();

    header("Location: view_users.php");
    exit();
}

// Fetch users from the database
$sql = "SELECT * FROM register";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - View Users</title>
    <link rel="icon" href="logo.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        /* Main Content Styling */
        .container {
            margin-left: 270px;
            margin-top: 70px;
            padding: 20px;
            width: calc(100% - 270px);
        }

        .container h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #28a745;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            margin: 5px;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #1e7e34;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .no-data {
            text-align: center;
            font-size: 18px;
            margin: 20px 0;
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
        <h2>Registered Users</h2>
        <a href="add_user.php" class="btn">Add New User</a>

        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Date of Birth</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Country</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['Firstname']); ?></td>
                            <td><?php echo htmlspecialchars($row['Lastname']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phonenumber']); ?></td>
                            <td><?php echo htmlspecialchars($row['dateofbirth']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td><?php echo htmlspecialchars($row['country']); ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                                <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">No users found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$connection->close();
?>
