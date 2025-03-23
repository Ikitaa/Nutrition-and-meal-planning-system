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

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = intval($_POST['order_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update order status in the database
    $query = "UPDATE orders SET status = '$status' WHERE order_id = $order_id";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Order status updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update order status.";
    }

    // Redirect back to the manage orders page
    header("Location: order_admin.php");
    exit;
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: order_admin.php");
    exit;
}

// Close the database connection
mysqli_close($conn);
?>
