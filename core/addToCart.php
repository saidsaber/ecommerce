<?php
// include('config.php');
function addToCart($id , $prodcutId ){
    $conn = $GLOBALS['conn'];
    var_dump(ifIsset($id , $prodcutId));
    // exit;
    if(ifIsset($id , $prodcutId) == 0){
        insertCart($id , $prodcutId );
    }else{
        updateCart($id , $prodcutId);
    }
}

function ifIsset($id , $prodcutId){
    $conn = $GLOBALS['conn'];
    $query = "SELECT * FROM cart WHERE productId = $prodcutId and userId = {$_SESSION['user']} and shipmentId = 0";
    $result = mysqli_query($conn , $query);
    ($row = mysqli_fetch_assoc($result));
    if(isset($row)){
        return $row;
    }else{
        return 0;
    }
    
}

function insertCart($id , $prodcutId){
    $conn = $GLOBALS['conn'];
    $query = "INSERT INTO cart (userId , productId , count) VALUES ('$id' ,  '$prodcutId' , 1)";
    mysqli_query($conn , $query);
    return 1;
}

function updateCart($id , $prodcutId){
    $conn = $GLOBALS['conn'];
    $cartId = ifIsset($id , $prodcutId)['cartId'];
    $count = ifIsset($id , $prodcutId)['count'];
    ++$count;
    $query = "UPDATE cart SET count = $count where cartId = '$cartId' ";
    mysqli_query($conn , $query);
}