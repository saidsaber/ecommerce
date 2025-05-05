<?php
session_start();
include("../core/login.php");
if($_SERVER['REQUEST_METHOD'] == "POST" ){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $userData = [
        'email' => $email,
        'password' => $password
    ];
    createUser($userData);
}