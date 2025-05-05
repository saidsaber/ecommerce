<?php
session_start();
include("../core/register.php");
if($_SERVER['REQUEST_METHOD'] == "POST" ){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    $userData = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'password' => $password
    ];
    createUser($userData);
}