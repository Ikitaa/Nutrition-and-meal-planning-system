<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - Admin</title>
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
        .main-content {
            margin-left: 270px;
            margin-top: 70px;
            padding: 20px;
            width: calc(100% - 270px);
            transition: margin-left 0.3s;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card h3 {
            margin-top: 0;
        }

        .card button {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }

        .card button:hover {
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


    <div class="main-content" id="main-content">
        <div class="card">
            <h3>Welcome to the Admin Dashboard</h3>
        </div>

        <div class="card">
            <h3>Quick Actions</h3>
            <div>
                <button onclick="window.location.href='view_users.php'">View Users</button>
                <button onclick="window.location.href='manage_meal_plans.php'">Manage Meal Plans</button>
                <button onclick="window.location.href='grocery_admin.php'">Grocery List</button>
            </div>
        </div>
    </div>
</body>
</html>
