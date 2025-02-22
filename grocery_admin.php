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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
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

        .containers {
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

        .container {
            margin-top: 80px;
            padding: 20px;
            max-width: 1000px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .grocery-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .grocery-table th, .grocery-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
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
    </style>
</head>
<body>

<header>
    <div class="containers">
        <div class="logo">
            <a href="dashboard.php">
                <img src="logo.png" alt="SmartDiet Logo"> SmartDiet
            </a>
        </div>
    </div>
</header>

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
                    echo "<td>" . htmlspecialchars($row['image_url']) . "</td>";
                    echo "<td><a href='grocery_admin.php?edit_id=" . $row['grocery_id'] . "'>Edit</a> | <a href='grocery_admin.php?delete_id=" . $row['grocery_id'] . "'>Delete</a></td>";
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
