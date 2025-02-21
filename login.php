<?php
session_start(); 
require_once 'login.function.php';
$error = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (checkEmptyField('username')) {
        $username = $_POST['username'];
        if (!validatePattern($username, '/^[A-Za-z][a-zA-Z0-9_]{4,14}$/')) {
            $error['username'] = "Enter a valid username.";
        }
    } else {
        $error['username'] = "Enter your username.";
    }

    if (checkEmptyField('password')) {
        $password = $_POST['password'];
    } else {
        $error['password'] = "Enter your password.";
    }
    if (count($error) == 0) {
        $user_id = checkValidUserFromDatabase($username, $password); // Get user_id instead of true/false
        
        if ($user_id) {
            $_SESSION['user_id'] = $user_id; // Set user_id in session
            $_SESSION['success'] = 'Login successful!';
            $_SESSION['username'] = $username; // Store username in session
    
            if (isset($_SESSION['from_register'])) {
                unset($_SESSION['from_register']); 
                header("Location: meal_form.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $error['message'] = 'Invalid Username/Password';
        }
    }
    
}

// Preserve success message for display
if (isset($_SESSION['success'])) {
    $successMessage = $_SESSION['success'];
    unset($_SESSION['success']); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - Log in</title>
    <link rel="icon" href="logo.png" type="image/png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', Arial, sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url(img/bg.jpg) no-repeat;
            background-size: cover;
            background-position: center;
        }
        /*header*/
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
        .container {
            width: 420px;
            background-color: transparent;
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(10px);
            color: black;
            border-radius: 12px;
            padding: 30px 40px;

        }
        .container h1 {
            font-size: 36px;
            text-align: center;
            color: black;
        }
        .container .group-field {
            width: 100%;
            height: 50px;
            margin: 30px 0;
            position: relative;
        }
        .group-field input {
            width: 100%;
            height: 100%;
            background-color: transparent;
            border:1px solid rgb(20, 20, 20);
            outline: none;
            border-radius: 40px;
            font-size: 16px;
            color: black;
            padding: 15px;
        }
        .group-field input::placeholder {
            color: gray;

        }
        .group-field i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translate(-50%);
            font-size: 20px;
        }
        .remember_me {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14.5px;
            margin: -15px 0 15px;
        }
        .remember_me label {
            display: flex;
            align-items: center;
        }
        .remember_me input[type="checkbox"] {
            margin-right: 5px; 
        }
        .container .button-link {
            width: 100%;
            height: 45px;
           
            border: none;
            outline: none;
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            cursor: pointer;
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }
        .container .login {
            font-size: 14.5px;
            text-align: center;
            margin: 20px 0 15px;
        }
        .login a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }
        .login a:hover{
            text-decoration: underline;
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
    <div class="container">
            <form action="#" method="POST" enctype="multipart/form-data">
                <h1>Login</h1>
                <div class="group-field">
                    <label for="username"></label>
                    <input type="text" id="username" name="username" placeholder="username" required="required">
                    <i class='bx bxs-user'></i>
                    <?php echo printError($error, 'username'); ?>
                </div>
                <div class="group-field">
                    <label for="password"></label>
                    <input type="password" id="password" name="password" placeholder="password" required="required">
                    <i class='bx bxs-lock-alt'></i>
                    <?php echo printError($error, 'password'); ?>
                </div>
                <div class="remember_me">
                    <label for="remember">
                    <input type="checkbox" id="remember" name="remember">
                    Remember Me
                    </label>
                    <a href="#">Forgot Password?</a>
                </div>
                <div class="login">
                    <button type="submit" class="button-link">Log In</button>
                </div>

                <div class="login">
                <a href="register.php" class="button-link">Don't have an Account? Register</a>
                </div>
            </form>
            <?php if (!empty($error['message'])): ?>
                <div class="error-message" style="color: red;">
                    <?php echo htmlspecialchars($error['message']); ?>
                </div>
            <?php endif; ?>
            <?php if ($successMessage): ?>
                <div class="success-message" style="color: green;">
                    <?php echo htmlspecialchars($successMessage); ?>
                </div>
            <?php endif; ?>
    </div>
</body>
</html>
