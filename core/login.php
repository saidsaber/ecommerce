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

    if(isEmail($userData['email']) != 1){
        $_SESSION['error'] += ['email' => [isEmail($userData['email']) , $userData['email']]];
        $isError = true;
    }else{
        $_SESSION['error'] += ['email' => [isEmail($userData['email']) , $userData['email']]];

    }


    $_SESSION['error'] += ['password' => [1 ,  $userData['password']]];
    return $isError;
}

function createUser($userData){
    if(isRequired($userData)){
        header("Location: ../login.php");
        exit;
    }
    if(lengthMoreFour($userData)){
        header("Location: ../login.php");
        exit;
    }
    if(validation($userData)){
        header("Location: ../login.php");
        exit;
    }

    $email = $userData['email'];
    $password = $userData['password'];
    $query = "SELECT * FROM users WHERE email = '$email'";

    $_SESSION['error'] = null;

    $x = mysqli_query($GLOBALS['conn'] , $query);
    $result = mysqli_fetch_assoc($x);

    if(password_verify($userData['password'], $result['password'])){
        $_SESSION['user'] = $result['userId'] ;
        header("Location: ../index.php");
        exit;
    }else{
        $_SESSION['error'] = ['error' => 'your email or password is not corect'];
        echo $_SESSION['error']['error'];
        header("Location: ../login.php");
        exit;
    }
}