
<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartdiet";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user profile data
$query = "SELECT firstname, middlename, lastname, email, phonenumber, dateofbirth, address, gender, country, photo_url FROM register WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $dateofbirth = $_POST['dateofbirth'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];

    // Handle photo upload or removal
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        // New photo uploaded
        $photo_tmp_name = $_FILES['photo']['tmp_name'];
        $photo_name = basename($_FILES['photo']['name']);
        $photo_url = 'uploads/' . $photo_name;

        // Check if the file is an image
        $check = getimagesize($photo_tmp_name);
        if ($check !== false) {
            // Move the uploaded file to the uploads folder
            move_uploaded_file($photo_tmp_name, $photo_url);

            // Remove the old photo from the server if there's one
            if ($user['photo_url'] && file_exists($user['photo_url'])) {
                unlink($user['photo_url']);
            }
        } else {
            echo "Uploaded file is not an image.";
        }
    } elseif (isset($_POST['remove_photo'])) {
        // Remove photo and update database to NULL
        $photo_url = null;
        if ($user['photo_url'] && file_exists($user['photo_url'])) {
            unlink($user['photo_url']); // Deletes the photo from the server
        }
    } else {
        // No change to photo (keep the current photo URL)
        $photo_url = $user['photo_url'];
    }

    // Update user data in the database
    $update_query = "UPDATE register SET 
                        firstname = ?, middlename = ?, lastname = ?, email = ?, phonenumber = ?, 
                        dateofbirth = ?, address = ?, gender = ?, country = ?, photo_url = ? 
                     WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('ssssssssssi', $firstname, $middlename, $lastname, $email, $phonenumber, 
                             $dateofbirth, $address, $gender, $country, $photo_url, $user_id);
    $update_stmt->execute();
    $update_stmt->close();

    // Redirect to reflect changes
    header("Location: profile.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="icon" href="logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Your existing CSS here */
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .menu li {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: inline-block;
            margin-right: 20px;
        }

        .menu li a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
            padding: 8px 12px;
        }

        .menu li a:hover {
            color: #28a745;
        }

        .save-btn {
            padding: 12px 25px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            display: block;
            margin: 20px auto;
        }

        .save-btn:hover {
            background-color: #218838;
        }

        .profile-container {
            max-width: 800px;
            margin: 100px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-container h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .profile-info label {
            font-weight: bold;
            color: #333;
        }

        .profile-info input {
            font-size: 16px;
            padding: 8px;
            width: 100%;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .profile-photo {
            margin: 20px auto;
            position: relative;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #ddd;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .upload-btn {
            position: absolute;
            bottom: -10px;
            right: 10px;
            background-color: transparent;
            color: #28a745;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        .upload-btn:hover {
            color: #218838;
        }

        .remove-btn {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px;
            font-size: 14px;
            cursor: pointer;
            border-bottom-left-radius: 5px;
        }

        .remove-btn:hover {
            background-color: #c82333;
        }

        footer {
            margin-top: 50px;
            text-align: center;
            padding: 10px 0;
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <a href="dashboard.php">
            <img src="logo.png" alt="Smart Diet Logo"> SmartDiet
        </a>
    </div>
</header>

<div class="profile-container">
    <h2>Edit Your Profile</h2>

    <!-- Profile Photo Section -->
    <div class="profile-photo">
        <?php if ($user['photo_url']): ?>
            <!-- Display existing photo -->
            <img src="<?php echo htmlspecialchars($user['photo_url']); ?>" alt="Profile Photo">
            <!-- Buttons to Change or Remove the photo -->
            <button type="submit" name="remove_photo" class="remove-btn">Remove Photo</button>
            <button type="button" class="upload-btn" onclick="document.getElementById('photo').click();">
                <i class="fa fa-pencil-alt"></i> Change Photo
            </button>
        <?php else: ?>
            <!-- If no photo exists, show a placeholder and option to upload a new photo -->
            <span>No Photo</span>
            <button type="button" class="upload-btn" onclick="document.getElementById('photo').click();">
                <i class="fa fa-pencil-alt"></i> Upload Photo
            </button>
        <?php endif; ?>

        <!-- Input to upload a new photo -->
        <input type="file" name="photo" id="photo" style="display:none;">
    </div>

    <form action="profile.php" method="POST" id="profile-form" enctype="multipart/form-data">
        <div class="profile-info">
            <label for="firstname">First Name:</label>
            <input type="text" name="firstname" id="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>">

            <label for="middlename">Middle Name:</label>
            <input type="text" name="middlename" id="middlename" value="<?php echo htmlspecialchars($user['middlename']); ?>">

            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" id="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>">

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>">

            <label for="phonenumber">Phone Number:</label>
            <input type="text" name="phonenumber" id="phonenumber" value="<?php echo htmlspecialchars($user['phonenumber']); ?>">

            <label for="dateofbirth">Date of Birth:</label>
            <input type="date" name="dateofbirth" id="dateofbirth" value="<?php echo htmlspecialchars($user['dateofbirth']); ?>">

            <label for="address">Address:</label>
            <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($user['address']); ?>">

            <label for="gender">Gender:</label>
            <input type="text" name="gender" id="gender" value="<?php echo htmlspecialchars($user['gender']); ?>">

            <label for="country">Country:</label>
            <input type="text" name="country" id="country" value="<?php echo htmlspecialchars($user['country']); ?>">
        </div>

        <button type="submit" class="save-btn">Save Changes</button>
    </form>
</div>

<footer>
    <p>&copy; 2025 SmartDiet</p>
</footer>

</body>
</html>

