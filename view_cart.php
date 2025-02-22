<?php
session_start();

// Check if cart is empty
if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
    $empty_cart = true;
} else {
    $empty_cart = false;
}

// Remove item from cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_item'])) {
    $grocery_id = $_POST['grocery_id'];

    // Remove the item from the cart
    foreach ($_SESSION["cart"] as $key => $item) {
        if ($item["grocery_id"] == $grocery_id) {
            unset($_SESSION["cart"][$key]);
            break;
        }
    }

    // Re-index the cart array after item removal
    $_SESSION["cart"] = array_values($_SESSION["cart"]);
    header("Location: view_cart.php");
    exit();
}

// Update item quantity
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_quantity'])) {
    $grocery_id = $_POST['grocery_id'];
    $quantity = $_POST['quantity'];

    // Update the quantity of the item
    foreach ($_SESSION["cart"] as &$item) {
        if ($item["grocery_id"] == $grocery_id) {
            $item["quantity"] = $quantity;
            break;
        }
    }
    header("Location: view_cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - View Cart</title>
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            padding-top: 30px; /* Ensure content starts below the fixed header */
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
        .container {
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
        .cart-table {
    width: 100%;
    margin: 20px auto;
    border-collapse: collapse;
    margin-top: 60px; /* Ensure it's spaced below the header */
}

        .cart-table, th, td {
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
        .cart-table .remove-button {
            padding: 8px 15px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .cart-table .remove-button:hover {
            background-color: #c82333;
        }
        .cart-table .update-button {
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .cart-table .update-button:hover {
            background-color: #0056b3;
        }
        .total-price {
            font-size: 20px;
            text-align: right;
            margin: 20px;
        }
        .checkout-button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 200px;
            margin: 0 auto;
            display: block;
            margin-top: 10px;
        }
        .checkout-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <div class="logo">
            <a href="dashboard.php">
                <img src="logo.png" alt="Smart Diet Logo"> SmartDiet
            </a>
        </div>
    </div>
</header>

<!-- Cart Table -->
<table class="cart-table">
    <thead>
        <tr>
            <th>Grocery ID</th>
            <th>Title</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($empty_cart): ?>
            <tr>
                <td colspan="6">Your cart is empty.</td>
            </tr>
        <?php else: ?>
            <?php
            $total_price = 0;
            foreach ($_SESSION["cart"] as $item):
                $subtotal = $item["price"] * $item["quantity"];
                $total_price += $subtotal;
            ?>
                <tr>
                    <td><?= htmlspecialchars($item["grocery_id"]) ?></td>
                    <td><?= htmlspecialchars($item["title"]) ?></td>
                    <td><?= htmlspecialchars($item["price"]) ?></td>
                    <td>
                        <form action="view_cart.php" method="POST" style="display:inline;">
                            <input type="number" name="quantity" value="<?= $item["quantity"] ?>" min="1" required>
                            <input type="hidden" name="grocery_id" value="<?= $item["grocery_id"] ?>">
                            <button type="submit" name="update_quantity" class="update-button">Update</button>
                        </form>
                    </td>
                    <td><?= $subtotal ?></td>
                    <td>
                        <form action="view_cart.php" method="POST" style="display:inline;">
                            <input type="hidden" name="grocery_id" value="<?= $item["grocery_id"] ?>">
                            <button type="submit" name="remove_item" class="remove-button">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php if (!$empty_cart): ?>
    <div class="total-price">
        <p>Total: $<?= number_format($total_price, 2) ?></p>
    </div>
    <form action="checkout.php" method="GET">
        <button type="submit" class="checkout-button">Proceed to Checkout</button>
    </form>
<?php endif; ?>

</body>
</html>
