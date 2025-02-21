<?php
// Database connection
$connection = new mysqli('localhost', 'root', '', 'smartdiet');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM register WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $dateofbirth = $_POST['dateofbirth'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];
    $username = $_POST['username'];

    $updateQuery = "UPDATE register SET 
                    Firstname = ?, lastname = ?, email = ?, phonenumber = ?, dateofbirth = ?, 
                    address = ?, gender = ?, country = ?, username = ? WHERE id = ?";
    $stmt = $connection->prepare($updateQuery);
    $stmt->bind_param(
        "sssssssssi",
        $firstname,
        $lastname,
        $email,
        $phonenumber,
        $dateofbirth,
        $address,
        $gender,
        $country,
        $username,
        $id
    );
    $stmt->execute();
    $stmt->close();
    header("Location: view_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDiet - Edit User</title>
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
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

        h1 {
            text-align: center;
            color: #28a745;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        td:first-child {
            font-weight: bold;
            text-align: right;
            width: 30%;
        }

        input, select, button {
            width: calc(100% - 20px);
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
        }

        button:hover {
            background-color: #1e7e34;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo-container">
            <div class="logo">
                <a href="view_users.php">
                    <img src="logo.png" alt="Smart Diet Logo"> SmartDiet
                </a>
            </div>
        </div>
    </header>
    <div class="container">
        <h1>Edit User</h1>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <table>
                <tr>
                    <td>First Name:</td>
                    <td><input type="text" name="firstname" value="<?php echo $user['Firstname']; ?>" required></td>
                </tr>
                <tr>
                    <td>Last Name:</td>
                    <td><input type="text" name="lastname" value="<?php echo $user['Lastname']; ?>" required></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="email" value="<?php echo $user['email']; ?>" required></td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td><input type="text" name="phonenumber" value="<?php echo $user['phonenumber']; ?>" required></td>
                </tr>
                <tr>
                    <td>Date of Birth:</td>
                    <td><input type="date" name="dateofbirth" value="<?php echo $user['dateofbirth']; ?>" required></td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td><input type="text" name="address" value="<?php echo $user['address']; ?>" required></td>
                </tr>
                <tr>
                    <td>Gender:</td>
                    <td>
                        <select name="gender" required>
                            <option value="Male" <?php echo $user['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo $user['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>                        
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Country:</td>
                    <td><input type="text" name="country" value="<?php echo $user['country']; ?>" required></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" value="<?php echo $user['username']; ?>" required></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <button type="submit">Save</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
