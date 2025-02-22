<?php
$conn = mysqli_connect("localhost", "root", "", "smartdiet");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the search term is provided
$searchTerm = isset($_POST['search_term']) ? $_POST['search_term'] : '';

$sql = "SELECT grocery_id, title, price, image_url FROM grocery WHERE title LIKE '%$searchTerm%'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet-Grocery</title>
    <link rel="icon" href="logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
    }

    /* Header Styling */
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

    .containers {
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

    .search-bar {
        flex: 1;
        max-width: 600px;
        margin: 0 auto;
    }

    .search-bar input {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .cart-icon {
        font-size: 1.5rem;
        color: #28a745;
        cursor: pointer;
    }

    .container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-top: 60px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 5px;
    }

    .card h3 {
        margin: 10px 0;
    }

    .price {
        font-weight: bold;
        color: #28a745;
    }

    .add-to-cart {
        display: inline-block;
        background-color: #007bff;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    .add-to-cart:hover {
        background-color: #0056b3;
    }
    </style>
</head>
<body>

<!-- Header Section -->
<header>
    <div class="containers">
        <div class="logo">
            <a href="dashboard.php">
                <img src="logo.png" alt="SmartDiet Logo"> SmartDiet
            </a>
        </div>
        <form action="" method="POST" class="search-bar">
            <input type="text" name="search_term" placeholder="Search for groceries..." value="<?php echo htmlspecialchars($searchTerm); ?>">
        </form>
        <div class="cart-icon">
        <a href="view_cart.php">
            <i class="fa fa-shopping-cart" style="font-size: 28px; color: #28a745;"></i> <!-- Dynamic cart count -->
        </a>
        </div>
    </div>
</header>

<h2>Smart Grocery</h2>
<div class="container">
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="card">';
            echo '<img src="'.$row['image_url'].'" alt="Grocery Image">';
            echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
            echo '<p class="price">Price: Rs' . number_format($row['price'], 2) . '</p>';
            echo '<form action="cart.php" method="POST">';
            echo '<input type="hidden" name="grocery_id" value="'.$row['grocery_id'].'">';
            echo '<input type="hidden" name="title" value="'.htmlspecialchars($row['title']).'">';
            echo '<input type="hidden" name="price" value="'.$row['price'].'">';
            echo '<button type="submit" class="add-to-cart">Add to Cart</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "<p>No grocery items found.</p>";
    }

    mysqli_close($conn);
    ?>
</div>

</body>
</html>
