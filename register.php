<?php
require_once 'register.function.php';
$error = [];
session_start(); // Start the session to store success messages

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate user inputs
    if (checkEmptyField('fname')) {
        $fname = htmlspecialchars(trim($_POST['fname']));
        if (!validatePattern($fname, '/^[A-Z][a-z]{1,24}$/')) {
            $error['fname'] = "Enter a valid first name";
        }
    } else {
        $error['fname'] = "Enter your first name";
    }

    if (checkEmptyField('lname')) {
        $lname = htmlspecialchars(trim($_POST['lname']));
        if (!validatePattern($lname, '/^[A-Z][a-z]{1,24}$/')) {
            $error['lname'] = "Enter a valid last name";
        }
    } else {
        $error['lname'] = "Enter your last name";
    }

    if (checkEmptyField('email')) {
        $email = htmlspecialchars(trim($_POST['email']));
        if (!validateEmail($email)) {
            $error['email'] = "Enter a valid email";
        }
    } else {
        $error['email'] = "Enter email";
    }

    if (checkEmptyField('phone')) {
        $phone = htmlspecialchars(trim($_POST['phone']));
        if (!validatePattern($phone, '/^\d{10}$/')) {
            $error['phone'] = "Enter a valid phone number";
        }
    } else {
        $error['phone'] = "Enter your number";
    }

    if (checkEmptyField('dob')) {
        $DOB = htmlspecialchars(trim($_POST['dob']));
        if (!validateDOB($DOB)) {
            $error['dob'] = "Enter a valid birth date";
        }
    } else {
        $error['dob'] = "Enter your DOB";
    }

    if (checkEmptyField('address')) {
        $address = htmlspecialchars(trim($_POST['address']));
    } else {
        $error['address'] = "Enter your address";
    }

    if (checkEmptyField('gender')) {
        $gender = htmlspecialchars(trim($_POST['gender']));
    } else {
        $error['gender'] = "Select your gender";
    }

    if (checkEmptyField('country')) {
        $country = htmlspecialchars(trim($_POST['country']));
    } else {
        $error['country'] = "Select your country";
    }

    if (checkEmptyField('username')) {
        $username = htmlspecialchars(trim($_POST['username']));
        if (!validatePattern($username, '/^[A-Za-z][a-zA-Z_]{4,14}$/')) {
            $error['username'] = "Enter a valid username.";
        }
    } else {
        $error['username'] = "Enter your username";
    }

    if (checkEmptyField('password') && checkEmptyField('confirm_password')) {
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        if ($password !== $confirmPassword) {
            $error['confirm_password'] = "Passwords do not match.";
        } elseif (strlen($password) < 8 || strlen($password) > 20) {
            $error['password'] = "Password must be between 8 and 20 characters.";
        } elseif (!preg_match('/[A-Z]/', $password)) {
            $error['password'] = "Password must contain at least one uppercase letter.";
        } elseif (!preg_match('/[a-z]/', $password)) {
            $error['password'] = "Password must contain at least one lowercase letter.";
        } elseif (!preg_match('/[0-9]/', $password)) {
            $error['password'] = "Password must contain at least one digit.";
        } elseif (!preg_match('/[\W_]/', $password)) {
            $error['password'] = "Password must contain at least one special character.";
        }
    } else {
        $error['password'] = "Enter your password.";
        $error['confirm_password'] = "Confirm your password.";
    }

    if (!isset($_POST['terms'])) {
        $error['terms'] = "You must agree to the Terms and Conditions.";
    }

    // Insert data into the database if no errors
    if (count($error) == 0) {
        try {
            $connection = new mysqli('localhost', 'root', '', 'smartdiet');
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


            // Prepare and bind statement
            $stmt = $connection->prepare("INSERT INTO register (Firstname, lastname, email, phonenumber, dateofbirth, address, gender, country, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssss", $fname, $lname, $email, $phone, $DOB, $address, $gender, $country, $username, $hashedPassword);

            

            if ($stmt->execute()) {
                $_SESSION['success'] = 'Registration successful! Please log in.';
                $_SESSION['from_register'] = true; // Register bata aayeko ho vanera track garne
                header("Location: login.php"); // Redirect to login.php after successful registration
                exit;
            } else {
                echo "SQL Error: " . $connection->error;
            }

            $stmt->close();
            $connection->close();
        } catch (Exception $th) {
            echo 'Error: ' . $th->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - Sign Up</title>
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
       

.container {
    width: 60%;
    padding: 20px 30px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: transparent;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    margin-top: 120px; /* Adjust this value as needed */
    backdrop-filter: blur(10px);
    
}

form fieldset {
    border: none;
    padding: 0;
}

form legend {
    text-align: center;
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
}

.group-field {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 15px;
}

.input {
    flex: 1;
}

label {
    font-weight: 500;
    margin-bottom: 5px;
    display: block;
    color: #333;
}

input[type="text"], 
input[type="email"], 
input[type="password"], 
input[type="date"], 
select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    color: #333;
    outline: none;
}

input::placeholder {
    color: #999;
}

input:focus {
    border-color: #28a745;
    box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
}
.input input {
    background-color: transparent;
    border:1px solid rgb(20, 20, 20);
}
 .input select {
    background-color:transparent;
    border:1px solid rgb(20, 20, 20);
 }


.field-group {
    margin-bottom: 15px;
}
.field-group input {
    background-color: transparent;
    border:1px solid rgb(20, 20, 20);
}

.field-group label a {
    color: #28a745;
    text-decoration: underline;
}


.field-group input[type="checkbox"] {
    margin-right: 5px;
}

.field-group a {
    display: inline-block;
    text-align: center;
    color: #28a745;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    transition: color 0.3s ease;
}

.field-group a:hover {
   text-decoration: underline
}

.account-message {
    text-align: center;
    margin-top: 20px;
}

.account-message a {
    color: #28a745;
    text-decoration: none;
    font-weight: 500;
}

.account-message a:hover {
    text-decoration: underline;
}

    .group button {
        display: inline-block;
        text-align: center;
        background: #28a745; /* Green background */
        color: white; /* White text */
        padding: 10px 20px; /* Add padding for better spacing */
        font-size: 16px; /* Set font size */
        font-weight: bold; /* Make text bold */
        border-radius: 5px; /* Rounded corners */
        text-decoration: none; /* Remove underline */
        border: none; /* Remove default button border */
        cursor: pointer; /* Pointer cursor */
        transition: background 0.3s ease, transform 0.3s ease; /* Smooth transition */
    }

    .group button:hover {
        background: #1e7e34; /* Darker green on hover */
        transform: scale(1.05); /* Slightly enlarge on hover */
    }

    .group button:active {
        background: #155d27; /* Even darker green on click */
        transform: scale(1); /* Reset scale on click */
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
        <fieldset>
            <legend>Create an account</legend>
            <div class="group-field">
                <div class="input">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" required="required">
                    <?php echo printError($error, 'fname'); ?> 
                </div>
                <div class="input">
                    <label for="mname">Middle Name</label>
                    <input type="text" id="mname" name="mname">
                    <?php echo printError($error, 'mname'); ?> 
                </div>
                <div class="input">
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname" required="required">
                    <?php echo printError($error, 'lname'); ?> 
                </div>
            </div>
            <div class="group-field">
                <div class="input">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required="required">
                    <?php echo printError($error, 'email'); ?> 
                </div>
                <div class="input">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" required="required">
                    <?php echo printError($error, 'phone'); ?> 
                </div>
                <div class="input">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" required="required">
                    <?php echo printError($error, 'address'); ?> 
                </div>  
            </div>
            <div class="group-field">
                <div class="input">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" required="required">
                    <?php echo printError($error, 'dob'); ?> 
                </div>
                <div class="input">
                    <label for="gender">Gender</label>
                    <input type="radio" name="gender" value="male"> Male

                    <input type="radio" name="gender" value="female"> Female
                    <input type="radio" name="gender" value="others"> Others
                    <?php echo printError($error, 'gender'); ?> 
                </div>
                <div class="input">
                    <label for="country">Country</label>
                    <select id="country" name="country" class="form-control" >
                        <option value="">Select your country</option>
                        <option value="nepal">Nepal</option>
                        <option value="india">India</option>
                        <option value="china">China</option>
                        <option value="australia">Australia</option>
                    </select>
                    <?php echo printError($error, 'country'); ?> 
                </div>
            </div>
            <div class="field-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required="required">
                <?php echo printError($error, 'username'); ?> 
            </div>
            <div class="field-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required="required">
                <?php echo printError($error, 'password'); ?> 
            </div>
            <div class="field-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required="required">
                <?php echo printError($error, 'confirm_password'); ?> 
            </div>
            <div class="field-group">
                <label for="terms">
                    <input type="checkbox" id="terms" name="terms"> I agree to the <a href="terms.html" target="_blank">Terms and Conditions</a>
                </label> 
                <?php echo printError($error, 'terms'); ?> 
            </div>
            <div class="group">
                <button type="submit">Sign Up</a></button>
            </div>
            <div id="response-message" style="display: none; text-align: center; margin-top: 20px;"></div>
            <div class="account-message">
        <p>Already have an account? <a href="login.php">Log in here</a>.</p>
    </div>
        </fieldset>
    </form>
    </div>


</body>
</html>
