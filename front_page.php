<?php
require_once 'head.php';
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
            margin-bottom: 50px;
        }
        /*section css */
        .section {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 120px;
            height: 100vh;
            padding: 0 20px;
            box-sizing: border-box;
            background-color: #F8F9FA;
        }
        /*text-content */
        .text-content {
            max-width: 500px;
            font-family: 'Poppins', Arial, sans-serif;
            color: #333;
            margin-top: 60px;
            opacity: 0; /*initally hides text content*/
            transform: translateX(-50px); /*move the text left*/
            transition: opacity 0.5s ease, transform 1s ease; /*apply transition*/
        }
        /*round rectangle with images*/
        .rounded-rectangle {
            width: 500px;
            height: 500px;
            background-color: #FFA500;
            border-top-left-radius: 100px;
            border-bottom-right-radius: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-top: 120px;
        }
        /*main image animations*/
        .inner-image {
            width: 95%;
            height: auto;
            border-radius: 20px;
            opacity: 0; /*hides images*/
            transform: translateX(200px); /*start off screnn to the left*/
            transition: opacity 0.5s ease, transform 1s ease;
        }
        /*lemon and tomato animation*/
        .lemon, .tomato {
            position: absolute;
            width: 150px;
            height: auto;
            opacity: 0;
            transform: translateY(200px);
            transition: opacity 0.5s ease, transform 1s ease;
        }
        .lemon {
            top: -30px;
            right: -35px;
        }
        .tomato {
            bottom: -35px;
            left: -30px;
        }
        .text-content h1 {
            font-size: 48px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 20px;
        }
        .text-content p {
            font-size: 20px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 30px;
        }
        .cta-button {
            display: inline-block;
            padding: 14px 30px;
            background-color: #FFA500;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-size: 18px;
            text-align: center;
            transition: background-color 0.3s ease;
            font-weight: bold;
        }
        .cta-button:hover {
            background-color: #e67e00;
        }
        /*section container*/
        .input {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 60px;
            padding: 20px;
            box-sizing: border-box;
            height: 100vh;
            background-color: #F8F9FA;
        }
        /*food div*/
        .food {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transform: translateX(-50px);
            transition: opacity 0.5s ease, transform 1s ease;
        }
        .food img {
            max-width: 70%;
            height: auto;
            border-radius: 15px;
            margin-top: 150px;
        }
        /*about div*/
        .about {
            flex: 1;
            font-family: 'Poppins', Arial, sans-serif;
            color: #333;
            opacity: 0;
            transform: translateX(50px);
            transition: opacity 0.5s ease, transform 1s ease;
            margin-top: 190px;
        }
        .about h2 {
            font-size: 36px;
            color: #28a745;
            margin-bottom: 15px;
        }
        .about p {
            font-size: 18px;
            line-height: 1.6;
            color: #555;
        }
        /*animation when the element enters the viewport*/
        .in-view {
            opacity: 1;
            transform: translateY(0); /* resest the transform for the final position*/
        }
        /*program section*/
        .program-section {
            padding: 40px;
            display: flex;
            gap: 40px;
            justify-content: center;
            align-items: flex-start;
            margin-top: 150px;
        }
        .service {
            flex: 1;
            text-align: left;
            padding: 20px;
            box-sizing: border-box;
            opacity: 0;
            transform: translateX(-50px); /*slides in from the left*/
            transition: opacity 0.5s ease, transform 1s ease;
        }
        .service h2{
            color: #28a745;
            font-size: 36px;
        }
        .service p {
            color: #555;
            font-size: 18px;
        }
        .service.in-view {
            opacity: 1; /*fully visible*/
            transform: translateX(0); /*reset position*/
        }
        .programs {
            flex: 2;
            border-radius: 10px;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .program-card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            flex: 1;
            opacity: 0;
            transform: translateY(50px);/*start wuth the element offscreen */
            transition: opacity 0.5s ease, transform 1s ease;
        }
        .program-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        .program-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .program-card p {
            font-size: 1rem;
            color: #555;
        }
        .program-card.in-view {
            opacity: 1;
            transform: translateY(0);
        }
        /*testimonial section*/
        .testimonial {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 70px;
            margin: 20px;
            margin-top: 50px;
        }
        .testimonial-image img {
            opacity: 0;
            transform: translateX(-200px); /*starts offscreen to the right*/
            transition: opacity 0.5s ease, transform 2s ease;
            max-width: 700px;
        }
        .testimonial-image img.in-view {
            opacity: 1;
            transform: translateX(0);
        }
        .testimonial-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            opacity: 0;
            transform: translateX(200px); /* Starts from the right */
            transition: opacity 0.5s ease, transform 1s ease; /* Slide transition*/
        }
        .testimonial-content.in-view {
             opacity: 1;
            transform: translateX(0); /* Moves to original position */
        }
        .testimonial-content h2 {
            font-size: 30px;
            color: #28a745;
            margin-bottom: 15px;
        }
        .testimonial-content p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 10px;
            text-align: justify;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        .user-info img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }
        .user-details h4 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .user-details p {
            margin: 0;
            font-size: 14px;
            color: gray;
        }
        .stars {
            margin-top: 10px;
            font-size: 18px;
            color: gold;
        }
        /*menu-field section*/
        .menu-field {
            text-align: center;
            padding: 50px 20px;
            background-color: #F8F9FA;
            position: relative;
        }
        .menu-field h2 {
            font-size: 2.5em;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 10px;
        }
        .menu-field p {
            font-size: 1.1em;
            color: #666;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .menu-container {
            display: flex;
            justify-content: center;
            gap: 50px;
            flex-wrap: wrap;
        }
        .menu-item {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            opacity: 0;
            transform: translateY(50px);
            transition: transform 1s ease, opacity 1s ease;
        }
        .menu-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .info {
            padding: 20px;
            text-align: center;
        }
        .info h3 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 10px;
        }
        .rating {
            font-size: 1.2em;
            color: #FFA500;
            margin-bottom: 15px;
        }
        button {
            background-color: #ff8c00;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #e67600;
        }
        .menu-item.visible {
            opacity: 1;
            transform: translateY(0);
        }
        /*get in touch section*/
        .get-in-touch {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background: linear-gradient(to right, #f9f9f9, #e0f7e8);
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .get-in-touch form {
            flex: 1;
            margin-right: 20px;
        }
        .get-in-touch form label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #333;
        }
        .get-in-touch form input,
        .get-in-touch form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .get-in-touch form button {
            background-color: #FFA500;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .get-in-touch form button:hover {
            background-color: #e69500;
        }
        .get-in-touch img {
            max-width: 400px;
            height: auto;
            border-radius: 8px;
            flex-shrink: 0;
            margin-bottom: 25px;
        }
        #get-in-touch { /*scrolle-triggered animation*/
            transform: translateY(100px);
            opacity: 0;
            transition: transform 1s ease-out, opacity 1s ease-out;
        }
        #get-in-touch.in-view {
            transform: translateY(0);
            opacity: 1;
        }
    </style>
</head>
<body>
    <section class="section">
        <!-- text content-->
        <div class="text-content slide-on-scroll">
            <h1>Your Guide to a Healthier<br />Lifestyle</h1>
            <p>Start your journey today with personalized<br />meal plans and tips to maintain a healthy lifestyle.</p>
            <a href="register.php" class="cta-button">Sign Up &nbsp&nbsp<span class="arrow">→</span></a>
        </div>
        <!--round rectangle with images-->
        <div class="rounded-rectangle">
            <img src="img/front1 1.png" alt="Main Image" class="inner-image slide-on-scroll">
            <img src="img/lemon 1.png" alt="Lemon" class="lemon slide-on-scroll">
            <img src="img/tomato.png" alt="Tomato" class="tomato slide-on-scroll">
        </div>
    </section>
    <!--about section-->
    <section class="input">
        <div class="food slide-on-scroll">
            <img src="img/front4 1.png" alt="Image">
        </div>
        <div class="about slide-on-scroll">
            <h2>Welcome to SmartDiet – Your Partner in Healthy Living!</h2>
            <p>At SmartDiet, we’re here to help you embrace a healthier lifestyle with personalized meal plans crafted just for you.</p>
            <p>Whether your goals is to lose weight, manage a health condition, or simply make better food choices, we make it simple and achievable.</p>
            <p>Join us on your journey to becoming the healthiest, happiest version of yourself! Let’s make eating well easier and more enjoyable together.</p>
            <a href="about.php" class="cta-button">Read more &nbsp&nbsp<span class="arrow">→</span></a>
        </div>
    </section>
    <!--service section-->
    <section class="program-section">
        <div class="service slide-on-scroll">
            <h2>The Services <br>SmartDiet <br>provides</h2>
            <p>Discover how SmartDiet can transform your health with our best offerings <br>Just for you!</p>
            <a href="img/services.php" class="cta-button">Read more &nbsp&nbsp<span class="arrow">→</span></a>
        </div>
        <div class="programs">
            <div class="program-card">
                <img src="img/service1 1.png" alt="Meal Plan">
                <h3>Meal Plans</h3>
                <p>Our customized meal plans consider your dietary preferences, guaranteeing that every meal is perfectly aligned with your taste.</p>
            </div>
            <div class="program-card">
                <img src="img/service22 1.png" alt="Grocery">
                <h3>Grocery Lists</h3>
                <p>Our smart grocery lists tracks what you already have, helping you avoid unnecessary purchases and reducing both food waste and extra spending.</p>
            </div>
            <div class="program-card">
                <img src="img/service3 1.png" alt="delivery">
                <h3>Delivery</h3>
                <p>Convenient delivery options allow you to shop from home using reliable platforms or provide curated lists for efficient in-store shopping.</p>
            </div>
        </div>
    </section>
    <!--Testimonial section-->
    <section class="testimonial">
        <div class="testimonial-image">
            <img src="img/girl 1.png" alt="person" class="slide-on-scroll">
        </div>
        <div class="testimonial-content slide-on-scroll">
            <h2>What Users Says About SmartDiet </h2>
            <p class="justified-text">"As someone with diabetes, SmartDiet has been life-changing.<br>The meal plans are tailored to my needs,<br>and I’ve seen amazing improvements!"</p>
            <div class="user-info">
                <img src="https://via.placeholder.com/50" alt="User">
                <div class="user-details">
                    <h4>Sita Shrestha</h4>
                    <p>SmartDiet User</p>
                </div>
            </div>
            <div class="stars">
                ⭐️⭐️⭐️⭐️⭐️
                <span>8.5</span>
            </div>
        </div>
    </section>
    <!--menu-field section-->
    <section class="menu-field">
        <div class="menu-section">
            <h2>Our Special Dish</h2>
            <p>"Every bite is a little moment of joy, crafted just for you."</p>
            <div class="menu-container">
                <div class="menu-item">
                    <img src="meals/38.jpeg" alt="dhido">
                    <div class="info">
                        <h3>Dhido</h3>
                        <div class="rating">⭐️ 8.5</div>
                        <button>Add to Cart</button>
                    </div>
                </div>
                <div class="menu-item">
                    <img src="meals/bhat dal.jpg" alt="dalbhat">
                    <div class="info">
                        <h3>Dhal Bhat</h3>
                        <div class="rating">⭐️ 8.5</div>
                        <button>Add to Cart</button>
                    </div>
                </div>
                <div class="menu-item">
                    <img src="meals/vegetable curry.jpg" alt="rotitarkari">
                    <div class="info">
                        <h3>Roti Tarkari</h3>
                        <div class="rating">⭐️ 8.5</div>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--get in touch section-->
    <section id="get-in-touch" class="get-in-touch">
        <form id="contactForm">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="message">Your Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>
            <button type="submit">Send Message</button>
        </form>
        <img src="img/bag 1.png" alt="grocery">
    </section>

    <!--javascript-->
    <script>
        //section
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return rect.top >=0 && rect.bottom <= window.innerHeight;
        }
        function checkElements() { //add 'in-view' class when the elements is in the viewport
            const elements = document.querySelectorAll('.slide-on-scroll');
            elements.forEach((element) => {
                if (isInViewport(element)) {
                    element.classList.add('in-view');
                }
            });
        }
        window.addEventListener('scroll', checkElements); //scroll event to trigger the animation
        document.addEventListener('DOMContentLoaded', checkElements); //calling the function to check whether any element is in view

        //programs
        document.addEventListener('DOMContentLoaded', () => {
            function isInViewport(element) {
                const rect = element.getBoundingClientRect();
                return rect.top >=0 && rect.bottom <= window.innerHeight;
            }
            function checkElements() {
                const elements = document.querySelectorAll('.program-card');
                elements.forEach((element) => {
                    if (isInViewport(element)) {
                        element.classList.add('in-view');
                    }
                });
            }
            checkElements(); //check if elements are in view on page load
            window.addEventListener('scroll',checkElements);
        });

        //about
        document.addEventListener('DOMContentLoaded', () => {
            function isInViewport(element) {
                const rect = element.getBoundingClientRect();
                return rect.top >= 0 && rect.bottom <= window.innerHeight;
            }
            function checkElements() {
                const elements = document.querySelectorAll('.slide-on-scroll');
                elements.forEach((element) => {
                    if (isInViewport(element)) {
                        element.classList.add('in-view');
                    }
                });
            }
            checkElements();
            window.addEventListener('scroll', checkElements);
        });

        //testimonial
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return rect.top >= 0 && rect.bottom <= window.innerHeight;
        }
        function checkElements() {
            const elements = document.querySelectorAll('.testimonial-image');
            elements.forEach((element) => {
                if(isInViewport(element)) {
                    element.classList.add('in-view');
                }
            });
        }
        window.addEventListener('scroll', checkElements);
        document.addEventListener('DOMContentLoaded', checkElements);

        //menu
        document.addEventListener("DOMContentLoaded",function(){
            const menuItems = document.querySelectorAll(".menu-field .menu-item");
            const revealMenuItems = () => {
                menuItems.forEach((item) => {
                    const rect = item.getBoundingClientRect();
                    if (rect.top < window.innerHeight - 50) {
                        item.classList.add("visible");
                    }
                });
            };
            window.addEventListener("scroll", revealMenuItems);
            revealMenuItems(); //reveal items on load
        });

        //get-in-touch
        document.addEventListener("DOMContentLoaded", () => {
            const getInTouchSection = document.querySelector("#get-in-touch");
            const isInViewport = (element) => {
                const rect = element.getBoundingClientRect();
                return (
                    rect.top < (window.innerHeight || document.documentElement.clientHeight) && 
                    rect.bottom >= 0
                );
            };
            const handleScroll = () => { //scroll event listener
                if (isInViewport(getInTouchSection)) {
                    getInTouchSection.classList.add("in-view");
                    window.removeEventListener("scroll", handleScroll);
                }
            };
            window.addEventListener("scroll", handleScroll); //scroll event listener
        });
    </script>
</body>
</html>
<?php
require_once 'foot.php';
?>