<?php
session_start();

// Ensure order_id exists
if (!isset($_SESSION['order_id'])) {
    echo "Error: Order ID is missing. Redirecting to cart...";
    header("Refresh: 3; url=view_cart.php");
    exit();
}

// Store order ID before unsetting the session (optional)
$order_id = $_SESSION['order_id'];

// Optional: Unset order_id session variable (depends on your workflow)
// unset($_SESSION['order_id']);
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
    font-family: 'Poppins', Arial, sans-serif;
    text-align: center;
    margin: 0;
    padding-top: 100px; /* Adds space to push content down */
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
    max-height: 50px; /* Ensures proper size */
    width: auto; /* Keeps aspect ratio */
    margin-right: 10px;
    vertical-align: middle; /* Aligns it properly */
}
.confirmation-box {
    max-width: 500px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ddd;
    box-shadow: 2px 2px 10px #ccc;
    border-radius: 10px;
    margin-top: 50px; /* Reduced margin to prevent too much space */
}
        .home-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
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
                <img src="logo.png" alt="Smart Diet Logo" width="50"> SmartDiet
            </a>
        </div>
    </div>
</header>

<div class="confirmation-box">
    <h2>Thank You for Your Order!</h2>
    <p>Your order has been successfully placed. We will process it soon.</p>
    <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
    <a href="dashboard.php" class="home-button">Return to Dashboard</a>
</div>

</body>
</html>
