<?php
require_once 'head.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - Contact</title>
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
            margin-top: -10px;
        }
        section.contact-us {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin: 20px auto;
            overflow: hidden;
        }
        .contact-content {
            flex: 1 1 500px;
            padding: 20px;
            transform: translateY(100px);
            opacity: 0;
            animation: slideUp 0.8s ease-in-out forwards;
        }

        fieldset {
            border: 2px solid #28a745;
            border-radius: 10px;
            padding: 20px;
            margin: 10px auto;
            max-width: 90%;
            box-sizing: border-box;
        }

        legend {
            color: #28a745;
            font-size: 1.5rem;
            padding: 0 10px;
            font-weight: bold;
        }

        label {
            display: block;
            margin-top: 15px;
            font-size: 1rem;
        }

        input, textarea {
            width: 90%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            font-family: inherit;
            box-sizing: border-box;
        }
        button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #FFA500;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s;
            max-width: 90%;
        }

        button:hover {
            background-color: #e69500;
        }
        .contact-info {
            margin-top: 20px;
            padding: 20px;
            border: 2px solid #28a745;
            border-radius: 10px;
            background-color: white;
        }

        .contact-info h2 {
            color: #333;
            font-size: 1.4rem;
        }

        .contact-info p {
            margin: 10px 0;
            font-size: 1rem;
        }

        .contact-info strong {
            color: #333;
        }
        .contact-image {
            flex: 1 1 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            transform: translateX(100px);
            opacity: 0;
            animation: slideIn 0.8s ease-in-out forwards;
        }

        .contact-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        @keyframes slideUp {
            from {
                transform: translateY(100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(100px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @media (max-width: 768px) {
            section.contact-us {
                flex-direction: column;
                align-items: center;
            }

            .contact-image {
            margin-top: 20px;
            }
        }
        section.map {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 40px auto;
            max-width: 100%;
        }
        iframe {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            <h1>Contact Us</h1>
            <p>"Reach out to SmartDiet-Your journey to healthier living starts here!"</p>
        </div>
        <div class="image">
            <img src="img/lemon 1.png" alt="tomato" id="tomatoImage">
        </div>
    </section>
    <section class="contact-us">
        <div class="contact-content">
        <fieldset>
            <legend>Contact Us</legend>
            <p>We'd love to hear from you! Reach out with any questions or feedback.</p>
            <form id="contactForm" action="#" method="POST">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="phone">Your Phone (optional):</label>
                <input type="tel" id="phone" name="phone">

                <label for="message">Your Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </fieldset>
        <div class="contact-info">
            <h2>Get in Touch:</h2>
            <p><strong>Email:</strong> support@smartdiet.com</p>
            <p><strong>Phone:</strong> +123-456-7890</p>
            <p><strong>Address:</strong> 123 Healthy Lane, Wellness City, Australia</p>
        </div>
        </div>
        <div class="contact-image">
            <img src="img/heart 1.png" alt="heart">
        </div>
    </section>
    <section class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.37138990335!2d85.31823757425403!3d27.70581722556114!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19077ca219b7%3A0xcada8fb23a81a282!2sPadmakanya%20Multiple%20Campus!5e0!3m2!1sen!2snp!4v1734792859642!5m2!1sen!2snp" 
            width="600" 
            height="450"
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
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