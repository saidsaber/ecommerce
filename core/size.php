<?php
include("validation.php");
include("config.php");
function isExest($sizeData){
    $isError = false;
    foreach($sizeData as $key => $value){
        if(required($value , $key) != 1){
            $isError = true;
        }
        $_SESSION['error'][$key] = [required($value , $key) , $value];
    }
    return $isError;
}
function setSize($sizeData){
    if(isExest($sizeData)){
        header("Location : ../admin/detiales/size.php");
        exit;
    }
    $query = "INSERT INTO size (productId , sizeName ) 
        VALUE ('{$sizeData["id"]}' , '{$sizeData['size']}' )";
    mysqli_query($GLOBALS["conn"], $query);
    $query = "UPDATE products SET haveDetails = 1 WHERE productId = '{$sizeData["id"]}'";
    mysqli_query($GLOBALS["conn"], $query);
    // header("Location : ../admin/detiales/size.php");
    exit;
}