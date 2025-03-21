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

$user_id = $_SESSION['user_id'];
$grocery_id = $_POST["grocery_id"];
$quantity = $_POST["quantity"];

// Prepare query to check if item already exists in the user's cart
$query = "SELECT * FROM cart WHERE user_id = ? AND grocery_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $grocery_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // If item exists, update quantity
    $query = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND grocery_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $quantity, $user_id, $grocery_id);
} else {
    // If item does not exist, insert new entry
    $query = "INSERT INTO cart (user_id, grocery_id, quantity) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $user_id, $grocery_id, $quantity);
}

// Execute the query and check for success
if (mysqli_stmt_execute($stmt)) {
    header("Location: view_cart.php"); // Redirect to the cart page
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the prepared statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
