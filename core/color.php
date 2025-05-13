<?php
include("validation.php");
include("config.php");
function isExest($colorData){
    $isError = false;
    foreach($colorData as $key => $value){
        if(required($value , $key) != 1){
            $isError = true;
        }
        $_SESSION['error'][$key] = [required($value , $key) , $value];
    }
    return $isError;
}
function setColor($colorData){
    if(isExest($colorData)){
        header('Location: ../admin/detiales/color.php');
        exit;
    }
    $query = "INSERT INTO color (productId , colorName , colorHexCode) 
        VALUE ('{$colorData["id"]}' , '{$colorData['color']}' , '{$colorData['colorHexCod']}')";
    mysqli_query($GLOBALS["conn"], $query);
    // header("Location : ../admin/detiales/color.php");
    $query = "UPDATE products SET haveDetails = 1 WHERE productId = '{$colorData["id"]}'";
    mysqli_query($GLOBALS["conn"], $query);
    exit;
}