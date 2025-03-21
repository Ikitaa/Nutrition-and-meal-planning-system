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
    <title>Your Orders</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your styles here -->
</head>
<body>
    <h2>Your Orders</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>Order ID</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Order Date</th>
                <th>Details</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <td>$<?php echo number_format($row['total_price'], 2); ?></td>
                    <td><?php echo ucfirst($row['payment_method']); ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                    <td><a href="order_details.php?order_id=<?php echo $row['order_id']; ?>">View</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
    
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
