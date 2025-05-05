<?php
include('../core/addToCart.php');
include('../core/config.php');
session_start();
if(isset($_SESSION['user'])){
    $id = $_SESSION['user'];
    $prodcutId = $_POST['productId'];
    // $colorAndSize = 'siad';
    // $colorAndSize = $_POST['colorAndSize'];
    // if(isset($_POST['colorAndSize'])){
    // }    

    // echo var_dump($colorAndSize);
    addToCart($id , $prodcutId);
    
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}else{
    $_SESSION['error'] = ['login' => 'you must be <a href="login.php">login </a> first'];
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}