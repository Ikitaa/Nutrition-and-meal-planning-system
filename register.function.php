<?php 
function checkEmptyField($index){
    if(isset($_POST[$index]) && !empty($_POST[$index]) && trim($_POST[$index])){
        return true;
    } else {
        return false;
    }
}

function validateEmail($data){
    if(filter_var($data,FILTER_VALIDATE_EMAIL)){
        return true;
    } else {
        return false;
    }
}

function validatePattern($data,$pattern){
    if(preg_match($pattern,$data)){
        return true;
    } else {
        return false;
    }
}


function validateAddress($address) {
    if(strlen($address) >= 5 && strlen($address) <= 50) {
        return true;
    } else {
    return false;
    }
}

function validateDOB($dob) {
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
        return false;
    }
    $date = DateTime::createFromFormat('Y-m-d', $dob);
    if ($date && $date->format('Y-m-d') === $dob && $date <= new DateTime()) {
        return true;
    }

    return false;
}


function validateGender($gender) {
    $Genders = ['male', 'female', 'Others'];
    if (in_array($gender, $Genders)) {
        return true;
    } else {
        return false;
    }
}

function validateCountry($country) {
    $Countries = ['nepal', 'india', 'china', 'australia'];
    if (in_array(strtolower($country), $Countries)) {
        return true;
    } else {
        return false;
    }
}

function printSuccess($error, $index){
    if(array_key_exists($index, $error)){
        return "<span class='success'>" . htmlspecialchars($error[$index], ENT_QUOTES) . "</span>";
    }
    return false;
}

function printError($error, $index){
    if(array_key_exists($index, $error)){
        return "<span class='error'>" . htmlspecialchars($error[$index], ENT_QUOTES) . "</span>";
    }
    return false;
}
?>