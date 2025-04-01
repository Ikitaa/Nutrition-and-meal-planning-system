<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "smartdiet");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if order_id is set
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    die("Error: Order ID is missing.");
}

$order_id = intval($_GET['order_id']); // Convert to integer for safety

// Fetch order details
$query = "SELECT orders.order_id, orders.user_id, orders.order_date, order_details.grocery_id, 
                 order_details.quantity, grocery.title, grocery.price 
          FROM orders
          JOIN order_details ON orders.order_id = order_details.order_id
          JOIN grocery ON order_details.grocery_id = grocery.grocery_id
          WHERE orders.order_id = $order_id";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="icon" href="logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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
            width: 90%;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-left: 270px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #28a745;
            color: white;
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
    <h2>Order Details</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Order Date</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $total_price = $row['price'] * $row['quantity'];
                    echo "<tr>";
                    echo "<td>" . $row['order_id'] . "</td>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $row['order_date'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "<td>Rs " . number_format($row['price'], 2) . "</td>";
                    echo "<td>Rs " . number_format($total_price, 2) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' style='text-align: center;'>No details found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php mysqli_close($conn); ?>
</body>
</html>
