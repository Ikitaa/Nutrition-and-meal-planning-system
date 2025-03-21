<?php
session_start();

// Database connection
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

// Get the cart item ID to remove
if (isset($_GET['id'])) {
    $cart_id = $_GET['id'];

    // Prepare query to delete the item from the cart
    $query = "DELETE FROM cart WHERE cart_id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $cart_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Redirect to the cart page after removal
        header("Location: view_cart.php");
        exit();
    } else {
        echo "Error removing item from cart.";
    }
} else {
    echo "Invalid cart item.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
