<?php
include('validation.php');
include('config.php');

function isRequired($categoryName){
    $isError = false;
    if(required($categoryName , 'catigory') != 1){
        $isError = true;
    }
    $_SESSION['error'] = ['catigory' => [required($categoryName , 'catigory') ,  $categoryName]];
    return $isError;
}

function lengthMoreFour($categoryName){
    $isError = false;
    if(length($categoryName , 'catigory') != 1){
        $isError = true;
    }
    $_SESSION['error'] = ['catigory' => [length($categoryName , 'catigory') , $categoryName]];
    return $isError;
}

function createCategory($categoryName){
    if(isRequired($categoryName)){
        header("Location: ../admin/CreateCategory.php");
        exit;
    }
    if(lengthMoreFour($categoryName)){
        header("Location: ../admin/CreateCategory.php");
        exit;
    }
    
    $query = "INSERT INTO catigory (cateName) VALUES ('$categoryName')";
    mysqli_query($GLOBALS['conn'] , $query);
    header("Location: ../admin/CreateCategory.php");
    exit;

}