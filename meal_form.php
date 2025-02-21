<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - MealForm</title>
    <link rel="icon" href="logo.png" type="image/png">
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
    background: url(img/register.jpg) no-repeat;
    background-size: cover;
    background-position: center;
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

form {
    background: transparent; /* Semi-transparent background */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 600px;
    margin-top: 80px;
    backdrop-filter: blur(10px);
}

fieldset {
    border: none;
}

legend {
    font-size: 24px;
    font-weight: bold;
    color: #28a745;
    margin-bottom: 20px;
}

.group-field {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.group-field .input input {
    background-color: transparent;
    border: 2px solid rgba(5, 5, 5, 0.2);
}
.group-field .input select {
    background-color: transparent;
    border: 2px solid rgba(5, 5, 5, 0.2);
}

.input {
    display: flex;
    flex-direction: column;
}

label {
    font-size: 16px;
    margin-bottom: 5px;
    color: #333;
}

input, select {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
    box-sizing: border-box;
}

button {
    padding: 12px 20px;
    font-size: 16px;
    color: white;
    background-color: #28a745;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #1e7e34;
}

button:active {
    background-color: #155d27;
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
    <form action="process.php" method="POST">
        <fieldset>
            <legend>Fill Up The Form</legend>
            <div class="group-field">
                <div class="input">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" min="1" max="120" required>
                </div>
                <div class="input">
                    <label for="weight">Choose your weight goal</label>
                    <select id="weight" name="weight" required>
                        <option value="">Choose your weight goal</option>
                        <option value="loss">Weight loss</option>
                        <option value="gain">Weight Gain</option>
                        <option value="maintain">Maintain Weight</option>
                    </select>
                </div>
                <div class="input">
                    <label for="diet">Dietary Preferences</label>
                    <select id="diet" name="diet" required>
                        <option value="">Choose Your Dietary Preferences</option>
                        <option value="anything">Anything</option>
                        <option value="vegetarian">Vegetarian</option>
                        <option value="non-vegetarian">Non-Vegetarian</option>
                    </select>
                </div>
                <div class="input">
                    <label for="disease">Disease/Condition:</label>
                    <select id="disease" name="disease" required>
                        <option value="">Choose if any Disease</option>
                        <option value="none">None</option>
                        <option value="hypertension">Hypertension</option>
                        <option value="gastritis">Gastritis</option>
                        <option value="diabetes">Diabetes</option>
                    </select>
                </div>
                <div class="input">
                    <button type="submit">Generate Meal Plan</button>
                </div>
            </div>
        </fieldset>
    </form>
</body>
</html>


