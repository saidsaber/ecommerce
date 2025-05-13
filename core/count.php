<?php
include("config.php");
function setCount($countData){
    $conn = $GLOBALS['conn'];
    $query = "INSERT INTO count (colorId , sizeId , count) 
        VALUE ('{$countData['color']}' , '{$countData['size']}' , '{$countData['count']}')";
    echo $query;
    mysqli_query($conn , $query);
    // header("Location : ../admin/detiales/count.php");
    exit;
}
