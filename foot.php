<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - Footer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="logo.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet"> <!-- Adding Poppins font -->
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            font-size: 15px;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        footer {
            background-color: white;
            color: black;
            padding: 20px;
            text-align: center;
            font-family: 'Poppins', Arial, sans-serif;
            width: 100%;
            box-sizing: border-box;
        }
        .footer-container {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            width: 100%;
            padding: 0;
        }
        .footer-top {
            display: flex;
            justify-content: space-between;
            width: 100%;
            flex-wrap: wrap;
        }
        .footer-left {
            flex: 1;
            text-align: left;
            margin-right: 20px;
        }
        .footer-left h2 {
            font-size: 34px;
            margin-bottom: 10px;
        }
        .footer-left h2 a {
            text-decoration: none;
            color: #28a745;
        }
        .footer-left p {
            font-size: 15px;
            margin-bottom: 10px;
        }
        .social-links a {
            margin-right: 15px;
            text-decoration: none;
            color: black;
        }
        .social-links a:hover {
            text-decoration: underline;
        }
        .footer-middle {
            display: flex;
            justify-content: space-around;
            flex: 2;
            width: 100%;
            flex-wrap: wrap;
        }
        .footer-middle h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .footer-middle ul {
            list-style: none;
            padding: 0;
        }
        .footer-middle ul li {
            margin-bottom: 12px;
        }
        .footer-middle a {
            text-decoration: none;
            color: black;
        }
        .footer-middle a:hover {
            text-decoration: underline;
        }
        .footer-right {
            text-align: center;
            width: 100%;
            padding: 4px 0;
            margin-top: 20px;
            color: gray;
            box-sizing: border-box;
        }
        footer p {
            font-size: 17px;
            margin-top: 5px;
        }
        .footer-left img {
            width: 30px;
            height: auto;
        }
        .footer-middle .contact-btn {
            display: inline-block;
            background-color: #FFb900;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 3px;
            display: flex;
            align-items: center;
            font-size: 15px;
            margin-top: 5px;
        }
        .footer-middle .contact-btn:hover {
            background-color: #ffa500;
        }
        .footer-middle .contact-btn .arrow {
            margin-left: 12px;
            font-size: 20px;
            transform: translateY(2px);
        }
    </style>
</head>
<body>
    <footer>
        <div class="footer-container">
            <div class="footer-top">
                <div class="footer-left">
                    <h2><a href="front.php"><img src="logo.png" alt="Smart Diet Logo"> SmartDiet</a></h2>
                    <p>Empowering you with personalized meal plans and nutrition guidance for a healthier lifestyle</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com" target="_blank"><i class="fa-brands fa-facebook" style="font-size: 24px; color:#48A860;"></i></a>
                        <a href="https://www.instagram.com" target="_blank"><i class="fa-brands fa-instagram" style="font-size: 24px; color:#48A860;"></i></a>
                        <a href="https://www.youtube.com" target="_blank"><i class="fa-brands fa-youtube" style="font-size: 24px; color:#48A860;"></i></a>
                        <a href="https://www.twitter.com" target="_blank"><i class="fa-brands fa-twitter" style="font-size: 24px; color:#48A860;"></i></a>
                    </div>
                </div>

                <div class="footer-middle">
                    <div>
                        <h3>About Us</h3>
                        <ul>
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="#">Features</a></li>
                            <li><a href="#">News</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3>Support</h3>
                        <ul>
                            <li><a href="#">Account</a></li>
                            <li><a href="#">Support Center</a></li>
                            <li><a href="#">Feedback</a></li>
                            <li><a href="contact.php">Contact Us</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3>Get in Touch</h3>
                        <p>Question or feedback?</p>
                        <p>We'd love to hear from you</p>
                        <a href="contact.php" class="contact-btn">
                            Contact Us
                            <span class="arrow">→</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-right">
                <p>&copy;2024 SmartDiet LLC, All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
