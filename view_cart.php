<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "smartdiet");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ensure user authentication
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Prepare query to get cart details with grocery item information
$query = "SELECT cart.*, grocery.title, grocery.price, grocery.image_url 
          FROM cart
          JOIN grocery ON cart.grocery_id = grocery.grocery_id
          WHERE cart.user_id = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt === false) {
    die("Error preparing the query: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $user_id);

if (!mysqli_stmt_execute($stmt)) {
    die("Error executing the query: " . mysqli_stmt_error($stmt));
}

$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding-top: 100px;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
            box-sizing: border-box;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            padding: 10px 20px;
        }
        .logo a {
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 32px;
            font-weight: 600;
            color: #28a745;
        }

        .logo img {
            max-height: 50px;
            width: auto;
            margin-right: 10px;
            vertical-align: middle;
        }

        /* Table Styling */
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #28a745;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        td a {
            text-decoration: none;
            color: #dc3545;
            font-weight: bold;
        }

        td a:hover {
            color: #c82333;
            text-decoration: underline;
        }

        /* Proceed to Checkout Button */
        .checkout-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 18px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease-in-out, transform 0.2s;
        }

        .checkout-btn:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        /* Status Styling */
        .status-pending {
            color: orange;
            font-weight: bold;
        }
    </style>
</head>
<body>
<header>
    <div class="header-container">
        <div class="logo">
            <a href="dashboard.php">
                <img src="logo.png" alt="Smart Diet Logo" width="50"> SmartDiet
            </a>
        </div>
    </div>
</header>

<h2>Your Shopping Cart</h2>
<table>
    <thead>
        <tr>
            <th>Item</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $cartNotEmpty = false; // Flag to check if cart has items

        if (mysqli_num_rows($result) > 0) {
            $cartNotEmpty = true; // Cart is not empty

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                echo "<td>Rs" . number_format($row['price'], 2) . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>Rs" . number_format($row['price'] * $row['quantity'], 2) . "</td>";
                echo "<td class='status-pending'>Pending</td>";
                echo "<td><a href='remove_from_cart.php?id=" . $row['cart_id'] . "'>Remove</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Your cart is empty.</td></tr>";
        }
        ?>
    </tbody>
</table>

<!-- Show "Proceed to Checkout" button only if cart is not empty -->
<?php if ($cartNotEmpty): ?>
    <a href="checkout_form.php" class="checkout-btn">Proceed to Checkout</a>
<?php endif; ?>

<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
</body>
</html>
