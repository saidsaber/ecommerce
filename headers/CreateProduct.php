<?php
session_start();
include('../core/CreateProduct.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $ProductName = $_POST['ProductName'];
    $Price = $_POST['Price'];
    $NumberOfPieces = $_POST['NumberOfPieces'];
    $category = $_POST['category'];
    $Title = $_POST['Title'];
    $Description = $_POST['Description'];
    $ditials = $_POST['ditials'];
    
    $ProductData = [
        'ProductName' => $ProductName,
        'Price' => $Price,
        'NumberOfPieces' => $NumberOfPieces,
        'category' => $category,
        'Title' => $Title,
        'Description' => $Description,
        'ditials' => $ditials
    ];

    validation($ProductData);
}