<?php
function checkEmptyField($index) {
    return isset($_POST[$index]) && !empty(trim($_POST[$index]));
}

function validatePattern($data, $pattern) {
    return preg_match($pattern, $data) === 1;
}

function printError($error, $index) {
    if (array_key_exists($index, $error)) {
        return "<span class='error'>" . htmlspecialchars($error[$index], ENT_QUOTES) . "</span>";
    }
    return '';
}
function checkValidUserFromDatabase($username, $password) {
    try {
        $connect = new mysqli('localhost', 'root', '', 'smartdiet');
        if ($connect->connect_error) {
            die("Connection failed: " . $connect->connect_error);
        }

        $stmt = $connect->prepare("SELECT id, password FROM register WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $hashed_password);
            $stmt->fetch();

        
            if (password_verify($password, $hashed_password)) {
                return $user_id;  // ✅ Return user ID
            }
        }
        return false; 
    } catch (Exception $ex) {
        die('Error: ' . $ex->getMessage());
    }
}

?>
  