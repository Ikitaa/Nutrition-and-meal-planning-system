<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - Admin Dashboard</title>
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
        }
        header {
            background-color: #28a745;
            color: white;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 24px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        header img {
            height: 40px;
            margin-right: 10px;
        }
        header .menu-toggle {
            background-color: transparent;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }
        .sidebar {
            width: 200px;
            background-color: #333;
            height: 100vh;
            color: white;
            padding: 15px;
            position: fixed;
            top: 0;
            left: 0;
            transform: translateX(0);
            transition: transform 0.3s ease;
            overflow-y: auto;
        }
        .sidebar.closed {
            transform: translateX(-100%);
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            margin: 8px 0;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .main-content {
            flex-grow: 1;
            margin-left: 200px;
            padding: 70px 20px 20px; /* Adjusted for the fixed header */
            transition: margin-left 0.3s ease;
        }
        .main-content.sidebar-closed {
            margin-left: 0;
        }
        .card {
            background-color: white;
            padding: 20px;
            margin: 15px 0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card h3 {
            margin-top: 0;
        }
        .card p {
            font-size: 16px;
        }
        .card button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .card button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <header>
        <div>
            <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
            <img src="logo.png" alt="Smart Diet Logo"> SmartDiet Admin Dashboard
        </div>
    </header>

    <div class="sidebar" id="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="view_users.php">View Users</a>
        <a href="manage_meal_plans.php">Manage Meal Plans</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main-content" id="main-content">
        <div class="card">
            <h3>Welcome to the Admin Dashboard</h3>
            <p>Here, you can manage users, view analytics, and manage meal plans for SmartDiet.</p>
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

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('closed');
            mainContent.classList.toggle('sidebar-closed');
        }
    </script>
</body>
</html>
