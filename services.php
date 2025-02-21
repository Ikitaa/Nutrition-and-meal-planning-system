<?php
require_once 'head.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - Service</title>
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .up {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5fdfd;
            padding: 10px 20px;
            margin-top: 70px;
        }
        .content {
            max-width: 50%;
            text-align: justify;
        }
        .content h1 {
            font-size: 2rem;
            color: #28a745;
            margin: 0;
        }
        .content p{
            font-size: 1rem;
            color: #333; margin-top: 10px;
        }
        .image img {
            max-width: 100px;
            height: auto;
            position: relative;
            transform: translateY(100px);
            transition: transform 1s ease-in-out;
            margin-left: 20px;
        }
        .aboutt {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 20px;
            overflow: hidden;
            margin-top: 20px;
        }
        .image-content {
            flex: 1; animation: slideUp 1s ease-in-out forwards;
        }
        .image-content img {
            max-width: 500px;
            height: auto;
            margin-left: 50px;
        }
        .services {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 20px;
            overflow: hidden;
            margin-top: 20px;
        }
        .service-image {
            flex: 1;
            animation: slideUp 1s ease-in-out forwards;
        }
        .service-image img {
            max-width: 500px;
            height: auto;
            margin-left: 50px;
        }
        .service-content {
            flex: 1;
            text-align: left;
            box-sizing: border-box;
            animation: slideRight 1s ease-in-out forwards;
            margin-bottom: 30px;
            margin-right: 50px
        }
        .service-content p {
            color: #333;
            font-size: 18px;
        }
        .service-content h2 {
            color: #28a745;
            font-size: 30px;
        }
        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        @keyframes slideRight {
            from {
                transform: translateX(50px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
            }
        }
        .meal {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            padding: 20px;
            overflow: hidden;
            margin-top: 50px;
        }
        .meal-content{
            flex: 1;
            text-align: left;
            justify-content: flex-end;
            margin-left: 60px;
            box-sizing: border-box;
        }
        .meal-content h2 {
            color: #28a745;
            text-align: left;
            font-size: 30px;
        }
        .meal-content p {
            color: #333;
            text-align: left;
            font-size: 18px;
        }
        .meal-image {
            flex: 1;
        }
        .meal-image img {
            max-width: 600px;
            height: auto;
            margin-left: 200px;
        }
        .meal-content, .meal-image {
            opacity: 0;
            transform: translateX(0);
            transition: transform 0.6s ease, opacity 0.6s ease;
        }
        .meal-content.active {
            opacity: 1;
            transform: translateX(50px);
        }
        .meal-image.active {
            opacity: 1;
            transform: translateX(-50px);
        }
        .grocery {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 20px;
            overflow: hidden;
            margin-top: 50px;
        }
        .grocery-image {
            flex: 1;
        }
        .grocery-image img {
            max-width: 400px;
            height: auto;
        }
        .grocery-content {
            flex: 1;
            text-align: left;
            box-sizing: border-box;
            margin-bottom: 30px;
            margin-left: 60px;
        }
        .grocery-content p {
            color: #333;
            font-size: 18px;
        }
        .grocery-content h2 {
            color: #28a745;
            font-size: 30px;
        }
        .grocery-content, .grocery-image {
            opacity: 0;
            transform: translateX(0);
            transition: transform 0.6s ease, opacity 0.6s ease;
        }
        .grocery-image.active {
            opacity: 1;
            transform: translateX(50px);
        }
        .grocery-content.active {
            opacity: 1;
            transform: translateX(-50px);
        }
        .delivery {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
            padding: 20px;
            overflow: hidden;
            margin-bottom: 100px;
        }
        .delivery-content {
            flex: 1;
            text-align: left;
            justify-content: flex-end;
            margin-left: 60px;
            box-sizing: border-box;
            margin-top: 20px;
        }
        .delivery-content h2 {
            color: #28a745;
            text-align: left;
            font-size: 30px;
        }
        .delivery-content p {
            color: #333;
            text-align: left;
            font-size: 18px;
        }
        .delivery-image {
            flex: 1;
        }
        .delivery-image img {
            max-width: 600px;
            height: auto;
            margin-left: 100px
        }
        .delivery-content, .delivery-image {
            opacity: 0;
            transform: translateX(0);
            transition: transform 0.6s ease, opacity 0.6s ease;
        }
        .delivery-content.active {
            opacity: 1;
            transform: translateX(50px);
        }
        .delivery-image.active {
            opacity: 1;
            transform: translateX(-50px);
        }
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
            margin-top: 20px;
        }
        .get-in-touch  form {
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
            background-color: #ffa500;
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
        #get-in-touch {
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
    <section class="up">
        <div class="content">
            <h1>Our Services</h1>
            <p>"SmartDiet: Personalized meal plans customized to your health goals and dietary needs."</p>
        </div>
        <div class="image">
            <img src="img/tomato.png" alt="tomato" id="tomatoImage">
        </div>
    </section>
    <section class="services">
        <div class="service-image">
            <img src="img/servicee 1.png" alt="service">
        </div>
        <div class="service-content">
            <h2>The services SmartDiet provides</h2>
            <p>SmartDiet provides everything you need for a healthier lifestyle: customized meal plans, tailored grocery lists,and reliable delivery services.<br>We make it easy to enjoy nutritous meals without the hassle, so you can focus on what matters most!</p>
        </div>
    </section>
    <section class="meal">
        <div class="meal-content">
            <h2>Smart Meal Plans</h2>
            <p>SmartDiet offers personalized meal plans that cater to your unique dietary needs,health goals, and preferences.<br>Whether you're looking to lose weight,manage a health condition, or simply eat healthier, our plans provide balanced,nutritous meals that fit seamlessly into your lifestyle.</p>
        </div>
        <div class="meal-image">
            <img src="img/meal 1.png" alt="meal">
        </div>
    </section>
    <section class="grocery">
        <div class="grocery-image">
            <img src="img/grocery.png" alt="grocery">
        </div>
        <div class="grocery-content">
            <h2>Smart Grocery Lists</h2>
            <p>To make meal plan preparations easier, SmartDiet provides curated grocery lists based on your personalized meal plans.<br>We ensure that every ingredient you need is included, helping you save time and shop with ease while staying focused on your health goals.</p>
        </div>
    </section>
    <section class="delivery">
        <div class="delivery-content">
            <h2>Delivery Service</h2>
            <p>Smartdiet's reliable delivery services bring your meal ingredients directly to your door, making healthy eating hassle-free.<br>With timely deliveries and carefully packed items, you can enjoy fresh,qulaity ingredients without ever leaving home.</p>
        </div>
        <div class="delivery-image">
            <img src="img/delivery 1.png" alt="delivery">
        </div>
    </section>
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

    <!--Javascript-->
    <script>
        window.onload = () => {  // Trigger the animation on page load
            const tomatoImage = document.getElementById('tomatoImage');
            tomatoImage.style.transform = 'translateY(0)'; // Animate the image to move up
        };
        //meal
        document.addEventListener("DOMContentLoaded", () => {
        const mealContent = document.querySelector(".meal-content ");
        const mealImage = document.querySelector(".meal-image");

        const handleScroll = () => {
            const windowHeight = window.innerHeight;
            const contentPosition = mealContent.getBoundingClientRect().top;
            const imagePosition = mealImage.getBoundingClientRect().top;

            // Check if elements are in the viewport
            if (contentPosition < windowHeight - 100) {
                mealContent.classList.add("active");
            } else {
                mealContent.classList.remove("inactive");
            }

            if (imagePosition < windowHeight - 100) {
                mealImage.classList.add("active");
            } else {
                mealImage.classList.remove("inactive");
            }
        };

        window.addEventListener("scroll", handleScroll);
        handleScroll(); // Call once to check initial position
        });

        //grocery
        document.addEventListener("DOMContentLoaded", () => {
        const groceryContent = document.querySelector(".grocery-content ");
        const groceryImage = document.querySelector(".grocery-image");

        const handleScroll = () => {
            const windowHeight = window.innerHeight;
            const contentPosition = groceryContent.getBoundingClientRect().top;
            const imagePosition = groceryImage.getBoundingClientRect().top;

            // Check if elements are in the viewport
            if (contentPosition < windowHeight - 100) {
                groceryContent.classList.add("active");
            } else {
                groceryContent.classList.remove("inactive");
            }

            if (imagePosition < windowHeight - 100) {
                groceryImage.classList.add("active");
            } else {
                groceryImage.classList.remove("inactive");
            }
        };
        window.addEventListener("scroll", handleScroll);
        handleScroll(); // Call once to check initial position
        });

        //delivery
        document.addEventListener("DOMContentLoaded", () => {
        const deliveryContent = document.querySelector(".delivery-content ");
        const deliveryImage = document.querySelector(".delivery-image");

        const handleScroll = () => {
            const windowHeight = window.innerHeight;
            const contentPosition = deliveryContent.getBoundingClientRect().top;
            const imagePosition = deliveryImage.getBoundingClientRect().top;

            // Check if elements are in the viewport
            if (contentPosition < windowHeight - 100) {
                deliveryContent.classList.add("active");
            } else {
                deliveryContent.classList.remove("inactive");
            }

            if (imagePosition < windowHeight - 100) {
                deliveryImage.classList.add("active");
            } else {
                deliveryImage.classList.remove("inactive");
            }
        };

        window.addEventListener("scroll", handleScroll);
        handleScroll(); // Call once to check initial position
        });

        //get in touch
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