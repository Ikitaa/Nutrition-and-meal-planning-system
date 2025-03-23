<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartdiet";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect if not logged in
    exit();
}

$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0; // Get order_id from query parameter

// Fetch order details for the specific order_id
$sql = "SELECT od.order_id, od.grocery_id, od.quantity, od.price, g.title AS grocery_name
        FROM order_details od
        INNER JOIN grocery g ON od.grocery_id = g.grocery_id
        WHERE od.order_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet</title>
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
        .orders {
    margin-top: 80px; /* Moves the orders section down */
    text-align: center;
}

        table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #28a745;
    color: white;
    font-weight: bold;
}

tr:hover {
    background-color: #f1f1f1;
}

td:last-child, th:last-child {
    font-weight: bold;
    color: #28a745;
}

.total-row {
    font-weight: bold;
    background-color: #f8f9fa;
}
.back-button {
    display: inline-block;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    border-radius: 5px;
    transition: background 0.3s ease, transform 0.2s ease;
    text-align: center;
}

.back-button:hover {
    background-color: #218838;
    transform: scale(1.05);
}


    </style>
</head>
<body>
<header>
        <div class="header-container">
            <div class="logo">
                <a href="dashboard.php">
                    <img src="logo.png" alt="Smart Diet Logo">SmartDiet
                </a>
            </div>
        </div>
    </header>
    <div class="orders">
    <h2>Order Details - Order ID: <?php echo $order_id; ?></h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>Grocery Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
            <?php
            $total_price = 0;
            while ($row = $result->fetch_assoc()):
                $total = $row['quantity'] * $row['price'];
                $total_price += $total;
            ?>
                <tr>
                    <td><?php echo $row['grocery_name']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td>$<?php echo number_format($row['price'], 2); ?></td>
                    <td>$<?php echo number_format($total, 2); ?></td>
                </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="3" align="right"><strong>Total Price:</strong></td>
                <td><strong>$<?php echo number_format($total_price, 2); ?></strong></td>
            </tr>
        </table>
    <?php else: ?>
        <p>No details found for this order.</p>
    <?php endif; ?>
    
    <a href="order.php" class="back-button">Back to Your Orders</a>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
