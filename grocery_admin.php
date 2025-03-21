<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "smartdiet");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle adding new grocery item
if (isset($_POST['add_grocery'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];

    $sql = "INSERT INTO grocery (title, price, image_url) VALUES ('$title', '$price', '$image_url')";
    if (mysqli_query($conn, $sql)) {
        echo "<p>Grocery item added successfully.</p>";
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
}

// Handle deleting a grocery item
if (isset($_GET['delete_id'])) {
    $grocery_id = $_GET['delete_id'];
    $sql = "DELETE FROM grocery WHERE grocery_id = '$grocery_id'";
    if (mysqli_query($conn, $sql)) {
        echo "<p>Grocery item deleted successfully.</p>";
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
}

// Handle editing a grocery item
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $result = mysqli_query($conn, "SELECT * FROM grocery WHERE grocery_id = '$edit_id'");
    $edit_data = mysqli_fetch_assoc($result);
}

// Fetch grocery items
$sql = "SELECT grocery_id, title, price, image_url FROM grocery";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - Grocery Admin</title>
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
            margin-top: 80px;
            padding: 20px;
            max-width: 1000px;
            margin: auto;
            margin-left: 280px;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .grocery-table {
    width: 100%;
    max-width: 1200px; /* Adjust as needed */
    margin: 0 auto;
}

.grocery-table th, .grocery-table td {
    padding: 15px;
    font-size: 16px;
    text-align: center;
}

.grocery-table img {
    max-width: 120px;
    height: auto;
}

        .grocery-table th {
            background-color: #28a745;
            color: white;
        }

        .grocery-table tr:hover {
            background-color: #f1f1f1;
        }

        .form-container {
            background-color: #f9f9f9;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container input, .form-container select {
            padding: 10px;
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-container button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        /* Edit Button - Red */
        .edit-button {
            color: #fff;
            background-color: #c82333;
            padding: 5px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .edit-button:hover {
            background-color: #9a1e26;
        }

        /* Delete Button - Green */
        .delete-button {
            color: #fff;
            background-color: #1e7e34;
            padding: 5px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-button:hover {
            background-color: #155724;
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
    <a href="cart_admin.php"><i class="fas fa-cart-arrow-down"></i> Manage Cart</a>
    <a href="order_admin.php"><i class="fas fa-box-open"></i> Manage Orders</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>
    
<div class="container">
    <h2>Grocery Management - Admin</h2>

    <!-- Add New Grocery Item -->
    <div class="form-container">
        <h3><?php echo isset($edit_data) ? 'Edit' : 'Add'; ?> Grocery Item</h3>
        <form method="POST" action="grocery_admin.php">
            <input type="text" name="title" placeholder="Grocery Title" value="<?php echo isset($edit_data) ? $edit_data['title'] : ''; ?>" required>
            <input type="number" name="price" placeholder="Price" value="<?php echo isset($edit_data) ? $edit_data['price'] : ''; ?>" required>
            <input type="text" name="image_url" placeholder="Image URL" value="<?php echo isset($edit_data) ? $edit_data['image_url'] : ''; ?>" required>
            <button type="submit" name="add_grocery"><?php echo isset($edit_data) ? 'Update' : 'Add'; ?> Grocery</button>
        </form>
    </div>

    <!-- Grocery Table -->
    <h3>All Grocery Items</h3>
    <table class="grocery-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Image URL</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                    echo "<td>Rs" . number_format($row['price'], 2) . "</td>";
                    echo "<td><img src='" . htmlspecialchars($row['image_url']) . "' alt='Grocery Image' width='100' height='100'></td>";
                    echo "<td>
                            <a href='grocery_admin.php?edit_id=" . $row['grocery_id'] . "'>
                                <button class='edit-button'>Edit</button>
                            </a>
                            <form action='grocery_admin.php' method='GET' style='display:inline;'>
                                <input type='hidden' name='delete_id' value='" . $row['grocery_id'] . "'>
                                <button type='submit' class='delete-button'>Delete</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No grocery items found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>
