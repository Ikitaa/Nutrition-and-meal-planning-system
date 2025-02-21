<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $grocery_id = $_POST['grocery_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];

    // Initialize cart if not set
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    // Check if item already exists in cart
    $found = false;
    foreach ($_SESSION["cart"] as &$item) {
        if ($item["grocery_id"] == $grocery_id) {
            $item["quantity"] += 1; // Increase quantity
            $found = true;
            break;
        }
    }

    // If item is new, add it to cart
    if (!$found) {
        $_SESSION["cart"][] = [
            "grocery_id" => $grocery_id,
            "title" => $title,
            "price" => $price,
            "quantity" => 1
        ];
    }

    // Redirect to view cart page
    header("Location: view_cart.php");
    exit();
}
?>
