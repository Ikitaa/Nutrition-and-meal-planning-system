<?php
session_start();

// Database connection
$servername = "localhost"; // or your server
$username = "root";        // your database username
$password = "";            // your database password
$dbname = "smartdiet"; // your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details from the database based on their username
$username = $_SESSION['username'];
$query = "SELECT firstname, lastname, phonenumber FROM register WHERE username = '$username'";
$result = mysqli_query($conn, $query);

// Fetch user data
$user = mysqli_fetch_assoc($result);
if (!$user) {
    // If the user doesn't exist, redirect to the login page
    header("Location: login.php");
    exit();
}
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
        header("Location: view_cart.php");
        exit();
    }
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $payment_method = $_POST['payment_method'];
    
    $_SESSION['order_details'] = [
        'name' => $name,
        'address' => $address,
        'phone' => $phone,
        'payment_method' => $payment_method,
        'cart' => $_SESSION['cart'],
        'total_price' => array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $_SESSION['cart']))
    ];
    
    header("Location: order_confirmation.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - SmartDiet</title>
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
            width: 50%;
            margin: auto;
            margin-top: 100px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        .submit-btn {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
        }
        .submit-btn:hover {
            background-color: #218838;
        }
        .payment-links {
            margin-top: 10px;
        }
        .payment-links a {
            display: block;
            margin-top: 5px;
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
    <div class="container">
        <form action="checkout.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Delivery Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phonenumber']); ?>" required>
            </div>
            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="cash">Cash on Delivery</option>
                    <option value="esewa">eSewa</option>
                    <option value="khalti">Khalti</option>
                </select>
            </div>
            
            <div class="payment-links" id="payment-links"></div>

            <button type="submit" class="submit-btn">Confirm Order</button>
        </form>
    </div>

    <script>
        document.getElementById('payment_method').addEventListener('change', function() {
            var paymentMethod = this.value;
            var paymentLinksDiv = document.getElementById('payment-links');
            
            if (paymentMethod === 'esewa') {
                paymentLinksDiv.innerHTML = '<a href="https://www.esewa.com.np" target="_blank">Click here to pay via eSewa</a>';
            } else if (paymentMethod === 'khalti') {
                paymentLinksDiv.innerHTML = '<a href="https://www.khalti.com" target="_blank">Click here to pay via Khalti</a>';
            } else {
                paymentLinksDiv.innerHTML = '';
            }
        });
    </script>
</body>
</html>
