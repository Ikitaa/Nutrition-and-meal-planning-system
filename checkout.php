<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartdiet";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details
$username = $_SESSION['username'];
$query = "SELECT id, firstname, lastname, phonenumber FROM register WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    header("Location: login.php");
    exit();
}

$user_id = $user['id'];
$name = $user['firstname'] . ' ' . $user['lastname'];
$phone = $user['phonenumber'];

// Handle checkout form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);

    // Calculate total price from cart
    $total_price = 0;
    $cart_query = "SELECT c.grocery_id, c.quantity, g.price 
                   FROM cart c 
                   JOIN grocery g ON c.grocery_id = g.grocery_id 
                   WHERE c.user_id = '$user_id'";
    $cart_result = mysqli_query($conn, $cart_query);

    if (mysqli_num_rows($cart_result) > 0) {
        while ($item = mysqli_fetch_assoc($cart_result)) {
            $total_price += $item['quantity'] * $item['price'];
        }

        // Insert into the orders table
        $order_date = date('Y-m-d H:i:s');
        $sql_order = "INSERT INTO orders (user_id, name, address, phone, payment_method, total_price, order_date) 
                      VALUES ('$user_id', '$name', '$address', '$phone', '$payment_method', '$total_price', '$order_date')";

        if (mysqli_query($conn, $sql_order)) {
            // Store order ID in session
            $_SESSION['order_id'] = mysqli_insert_id($conn);
            $order_id = $_SESSION['order_id'];

            // Insert order details
            $cart_items = mysqli_query($conn, $cart_query);
            while ($item = mysqli_fetch_assoc($cart_items)) {
                $grocery_id = $item['grocery_id'];
                $quantity = $item['quantity'];
                $price = $item['price'];

                $sql_detail = "INSERT INTO order_details (order_id, grocery_id, quantity, price) 
                               VALUES ('$order_id', '$grocery_id', '$quantity', '$price')";
                mysqli_query($conn, $sql_detail);
            }

            // Clear cart AFTER order is confirmed
            mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");

            // Redirect to order confirmation
            header("Location: order_confirmation.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Your cart is empty! Please add items before proceeding.";
    }
}

mysqli_close($conn);
?>
