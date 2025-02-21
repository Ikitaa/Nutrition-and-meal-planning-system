<?php
require_once 'head.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - About Us</title>
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
            color: #333;
            margin-top: 10px;
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
            flex: 1;
            animation: slideUp 1s ease-in-out forwards;
        }
        .image-content img {
            max-width: 500px;
            height: auto;
            margin-left: 50px;
        }
        .about-content {
            flex: 1;
            text-align: left;
            box-sizing: border-box;
            animation: slideRight 1s ease-in-out forwards;
            margin-bottom: 30px;
            margin-right: 50px
        }
        .about-content p {
            color: #333;
            font-size: 18px;
        }
        .about-content h2 {
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
        .mission {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 20px;
            overflow: hidden;
            margin-top: 50px;
        }
        .mission-content {
            flex: 1;
            text-align: left;
            justify-content: flex-end;
            margin-left: 60px;
            box-sizing: border-box;   
        }
        .mission-content h2 {
            color: #28a745;
            text-align: left;
            font-size: 30px;
        }
        .mission-content p {
            color: #333;
            text-align: left;
            font-size: 18px;
        }
        .mission-image {
            flex: 1;
        }
        .mission-image img {
            max-width: 600px;
            height: auto;
            margin-left: 100px;
        }
        .mission-content, .mission-image {
            opacity: 0;
            transform: translateX(0);
            transition: transform 0.6s ease, opacity 0.6s ease;
        }
        .mission-content.active {
            opacity: 1;
            transform: translateX(50px);
        }
        .mission-image.active {
            opacity: 1;
            transform: translateX(-50px);
        }
        .works {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 20px;
            overflow: hidden;
            margin-top: 50px;
        }
        .works-image {
            flex: 1;
        }
        .works-image img {
            max-width: 550px;
            height: auto;
        }
        .works-content {
            flex: 1;
            text-align: left;
            box-sizing: border-box;
            margin-bottom: 30px;
            margin-left: 60px;
        }
        .works-content p {
            color: #333;
            font-size: 18px;
        }
        .works-content h2 {
            color: #28a745;
            font-size: 30px;
        }
        .works-content, .works-image {
            opacity: 0;
            transform: translateX(0);
            transition: transform 0.6s ease, opacity 0.6s ease;
        }
        .works-image.active {
            opacity: 1;
            transform: translateX(50px);
        }
        .works-content.active {
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
            <h1>About Us</h1>
            <p>"SmartDiet offers personalized nutrition solutions to help you eat smarter and live healthier."</p>
        </div>
        <div class="image">
            <img src="img/tomato.png" alt="tomato" id="tomatoImage">
        </div>
    </section>
    <section class="aboutt">
        <div class="image-content">
            <img src="img/about 1 (1).png" alt="about">
        </div>
        <div class="about-content">
            <h2>About SmartDiet</h2>
            <p>At SmartDiet, we are dedicated to promoting healthier lifestyles through personalized nutrition solutions tailored to your unique needs.<br> Whether you're looking to lose weight, improve your diet, or manage a health condition, we offer a range of services to help you reach your goals.</p>
        </div>
    </section>
    <section class="mission">
        <div class="mission-content">
            <h2>Our Mission & Vision</h2>
            <p>SmartDiet helps individuals to lead healthier, happier lives through nutrition that fits their unique goals.</p>
            <p>We envision a world where everyone has access to personalized, science-backed meal plans that empower them to live their healthiest life.</p>
        </div>
        <div class="mission-image">
            <img src="img/Planetary-Health-Diet 1.png" alt="planet">
        </div>
    </section>
    <section class="works">
        <div class="works-image">
            <img src="img/work.png" alt="work">
        </div>
        <div class="works-content">
            <h2>How SmartDiet Works</h2>
            <p>SmartDiet takes a personalized approach to nutrition. When you sign up, we ask for some basic details like your age, wieght goals, and dietary preferences.<br>Based on your input, our system creates a tailored meal plan that suits your needs and lifestyle.</p>
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
    //mission
    document.addEventListener("DOMContentLoaded", () => {
        const missionContent = document.querySelector(".mission-content ");
        const missionImage = document.querySelector(".mission-image");

        const handleScroll = () => {
            const windowHeight = window.innerHeight;
            const contentPosition = missionContent.getBoundingClientRect().top;
            const imagePosition = missionImage.getBoundingClientRect().top;

            // Check if elements are in the viewport
            if (contentPosition < windowHeight - 100) {
                missionContent.classList.add("active");
            } else {
                missionContent.classList.remove("inactive");
            }

            if (imagePosition < windowHeight - 100) {
                missionImage.classList.add("active");
            } else {
                missionImage.classList.remove("inactive");
            }
        };

        window.addEventListener("scroll", handleScroll);
        handleScroll(); // Call once to check initial position
        });
    //works
    document.addEventListener("DOMContentLoaded", () => {
        const worksContent = document.querySelector(".works-content ");
        const worksImage = document.querySelector(".works-image");

        const handleScroll = () => {
            const windowHeight = window.innerHeight;
            const contentPosition = worksContent.getBoundingClientRect().top;
            const imagePosition = worksImage.getBoundingClientRect().top;

            // Check if elements are in the viewport
            if (contentPosition < windowHeight - 100) {
                worksContent.classList.add("active");
            } else {
                worksContent.classList.remove("inactive");
            }

            if (imagePosition < windowHeight - 100) {
                worksImage.classList.add("active");
            } else {
                worksImage.classList.remove("inactive");
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