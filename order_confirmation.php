<?php
session_start();

// Check if cart is empty before processing the order
if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
    header("Location: checkout.php"); // Redirect to cart if empty
    exit();
}

// Clear the cart after order placement
unset($_SESSION["cart"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
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
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .logo a {  text-decoration: none;
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
        .confirmation-box {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }
        .confirmation-box h2 {
            color: #28a745;
        }
        .confirmation-box p {
            font-size: 18px;
        }
        .home-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .home-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<header>
    <div class="header-container">
        <div class="logo">
            <a href="dashboard.php">
                <img src="logo.png" alt="Smart Diet Logo"> SmartDiet
            </a>
        </div>
    </div>
</header>
    <div class="confirmation-box">
        <h2>Thank You for Your Order!</h2>
        <p>Your order has been successfully placed. We will process it soon.</p>
        <a href="dashboard.php" class="home-button">Return to Dashboard</a>
    </div>
</body>
</html>
