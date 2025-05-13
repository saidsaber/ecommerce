<?php
include('../core/addToCart.php');
include('../core/config.php');
session_start();
if(isset($_SESSION['user'])){
    $id = $_SESSION['user'];
    $prodcutId = $_POST['productId'];
    $sizeId = $_POST['sizeId'];   
    $colorId = $_POST['colorId'];   

    // echo var_dump($colorAndSize);
    addToCart($id , $prodcutId , $sizeId , $colorId);
    
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}else{
    $_SESSION['error'] = ['login' => 'you must be <a href="login.php">login </a> first'];
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}