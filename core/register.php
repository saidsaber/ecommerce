<?php 
include('validation.php');
include('config.php');
function lengthMoreFour($userData){
    $isError = false;
    $_SESSION['error'] = [];
    foreach($userData as $field => $value){
        if(length($value , $field) != 1){
            $_SESSION['error'] += [$field => [length($value , $field) , $value]];
            $isError = true;
        }else{
            $_SESSION['error'] += [$field => [length($value , $field) , $value]];

        }
    }
    return $isError;
}
function isRequired($userData){
    $isError = false;
    $_SESSION['error'] = [];
    foreach($userData as $field => $value){
        if(required($value , $field) != 1){
            $_SESSION['error'] += [$field => [required($value , $field) ,  $value]];
            $isError = true;
        }else{
            
            $_SESSION['error'] += [$field => [required($value , $field) , $value]];
        }
    }
    return $isError;
}

function validation($userData){
    $isError = false;
    $_SESSION['error'] = [];
    if(isNumber($userData['phone']) != 1){
        $_SESSION['error'] += ['phone' => [isNumber($userData['phone']) ,$userData['phone']]];
        $isError = true;
    }else{
        $_SESSION['error'] += ['phone' => [isNumber($userData['phone']) ,$userData['phone']]];

    }

    if(isEmail($userData['email']) != 1){
        $_SESSION['error'] += ['email' => [isEmail($userData['email']) , $userData['email']]];
        $isError = true;
    }else{
        $_SESSION['error'] += ['email' => [isEmail($userData['email']) , $userData['email']]];

    }


    $_SESSION['error'] += ['name' => [1 ,  $userData['name']]];
    $_SESSION['error'] += ['password' => [1 ,  $userData['password']]];
    return $isError;
}

function createUser($userData){
    if(isRequired($userData)){
        header("Location: ../register.php");
        exit;
    }
    if(lengthMoreFour($userData)){
        header("Location: ../register.php");
        exit;
    }
    if(validation($userData)){
        header("Location: ../register.php");
        exit;
    }
    echo '<br>' , $userName = $userData['name'];
    echo '<br>' , $email = $userData['email'];
    echo '<br>' , $phone = $userData['phone'];
    echo '<br>' , $password = password_hash($userData['password'], PASSWORD_DEFAULT);
    $query = "INSERT INTO users (userName , email , phone , `password`) value ('$userName' , '$email' , '$phone' , '$password')";
    $_SESSION['error'] = null;
    mysqli_query($GLOBALS['conn'] , $query);
    header("Location: ../login.php");
    exit;
}