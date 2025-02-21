<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet</title>
    <link rel="icon" href="logo.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
       body {
        margin: 0;
        font-family: 'Poppins', Arial, sans-serif;
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
       .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
       }
       .logo a{
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
       nav .menu{
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
        gap: 20px;
       }
       nav .menu li {
        position: relative;
       }
       nav .menu li a {
        text-decoration: none;
        color: #333;
        font-size: 18px;
        padding: 8px 12px;
        transition: color 0.3s ease;
        white-space: nowrap;
       }
       nav .menu li a:hover,
       nav .menu li a.active {
        color: #28a745;
       }
       nav .menu li ul {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        list-style: none;
        padding: 0;
        margin: 0;
        background: white;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
       }
       nav .menu li:hover ul {
        display: block;
       }
       nav .menu li ul li {
        padding: 10px 15px;
       }
       nav .menu li ul li a {
        white-space: nowrap;
       }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="front_page.php">
                    <img src="logo.png" alt="Smart Diet Logo"> SmartDiet
                </a>
            </div>
            <nav>
                <ul class="menu">
                    <li><a href="front_page.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="login.php">Log In</a></li>
                </ul>
            </nav>
        </div>
    </header>
</body>
</html>
