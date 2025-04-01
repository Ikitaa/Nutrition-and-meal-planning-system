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

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
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
        .order {
    margin-top: 80px; /* Moves the orders section down */
    text-align: center;
}
        table 
        {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

th {
    background: #28a745;
    color: white;
    font-weight: bold;
}

tr:hover {
    background: #f5f5f5;
}

td a {
    text-decoration: none;
    color: #28a745;
    font-weight: bold;
}

td a:hover {
    text-decoration: underline;
}

td span {
    font-weight: bold;
}

@media (max-width: 768px) {
    table {
        width: 100%;
    }
    
    th, td {
        padding: 10px;
        font-size: 14px;
    }
}
.back-to-dashboard {
    display: inline-block;
    margin: 20px auto;
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    color: white;
    background-color: #28a745; /* Green color */
    text-decoration: none;
    border-radius: 6px;
    transition: background 0.3s, transform 0.2s;
    text-align: center;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
}

.back-to-dashboard:hover {
    background-color: #218838; /* Darker green */
    transform: scale(1.05);
}

.back-to-dashboard:active {
    transform: scale(0.98);
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
    <div class="order">
    <h2>Your Orders</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>Order ID</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Order Date</th>
                <th>Status</th> <!-- Added Status Column -->
                <th>Details</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <td>Rs<?php echo number_format($row['total_price'], 2); ?></td>
                    <td><?php echo ucfirst($row['payment_method']); ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                    <td>
                        <?php
                        // Display status based on the value in the 'status' column
                        switch ($row['status']) {
                            case 'Confirmed':
                                echo "<span style='color: blue;'>Confirmed</span>";
                                break;
                            case 'Shipped':
                                echo "<span style='color: green;'>Shipped</span>";
                                break;
                            case 'Delivered':
                                echo "<span style='color: brown;'>Delivered</span>";
                                break;
                            case 'Canceled':
                                echo "<span style='color: red;'>Canceled</span>";
                                break;
                            default:
                                echo "<span style='color: gray;'>Unknown</span>";
                                break;
                        }
                        ?>
                    </td>
                    <td><a href="order_details.php?order_id=<?php echo $row['order_id']; ?>">View</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
    
    <a href="dashboard.php" class="back-to-dashboard">Back to Dashboard</a>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
