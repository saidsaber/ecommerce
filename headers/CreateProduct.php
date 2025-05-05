<?php
session_start();
include('../core/CreateProduct.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $ProductName = $_POST['ProductName'];
    $Price = $_POST['Price'];
    $category = $_POST['category'];
    $Title = $_POST['Title'];
    $ditials = $_POST['ditials'];
    
    $ProductData = [
        'ProductName' => $ProductName,
        'Price' => $Price,
        'category' => $category,
        'Title' => $Title,
        'ditials' => $ditials
    ];

    validation($ProductData);
    // addDetails($ProductData, 19);
    exit;
}