<?php
session_start();

// Hardcoded admin credentials
$adminUsername = "admin";
$adminPassword = "smartdiet123";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check credentials
    if ($username === $adminUsername && $password === $adminPassword) {
        // Successful login
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_dashboard.php');
        exit;
    } else {
        // Invalid login
        header('Location: admin_login.php?error=1');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - Admin Login</title>
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url(img/admin.jpg);
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
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
        .logo-container {
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
        .login-container {
            width: 420px;
            background-color: transparent;
            padding: 30px 40px;
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(10px);
            color: black;
            border-radius: 12px;
        }
        .login-container h2 {
            font-size: 36px;
            color: black;
            text-align: center;
        }
        .login-container input {
            width: 100%;
            background-color: transparent;
            border:1px solid rgb(20, 20, 20);
            outline: none;
            border-radius: 40px;
            font-size: 16px;
            color: black;
            padding: 15px;
            margin-bottom: 15px;
        }
        .login-container button {
            width: 200px;
            padding: 12px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            font-size: 16px;
            margin: 0 auto;
            display: block;

        }
        .login-container button:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo-container">
            <div class="logo">
                <a href="front_page.php">
                    <img src="logo.png" alt="Smart Diet Logo"> SmartDiet
                </a>
            </div>
        </div>
    </header>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form action="admin_dashboard.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($_GET['error'])): ?>
            <div class="error">Invalid username or password</div>
        <?php endif; ?>
    </div>
</body>
</html>
