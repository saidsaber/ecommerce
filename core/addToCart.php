<?php
// include('config.php');
function addToCart($id , $prodcutId , $sizeId , $colorId){
    $conn = $GLOBALS['conn'];
    var_dump(ifIsset($id , $prodcutId , $sizeId , $colorId));
    // exit;
    if(ifIsset($id , $prodcutId , $sizeId , $colorId) == 0){
        insertCart($id , $prodcutId , $sizeId , $colorId);
    }else{
        updateCart($id , $prodcutId , $sizeId , $colorId);
    }
}

function ifIsset($id , $prodcutId , $sizeId , $colorId){
    $conn = $GLOBALS['conn'];
    $query = "SELECT * FROM cart WHERE productId = $prodcutId and userId = {$_SESSION['user']} and shipmentId = 0 and colorId = '$colorId' and sizeId='$sizeId'";
    $result = mysqli_query($conn , $query);
    ($row = mysqli_fetch_assoc($result));
    if(isset($row)){
        return $row;
    }else{
        return 0;
    }
    
}

function insertCart($id , $prodcutId , $sizeId , $colorId){
    $conn = $GLOBALS['conn'];
    $query = "INSERT INTO cart (userId , productId , count ,colorId , sizeId) 
        VALUES ('$id' ,  '$prodcutId'   , 1 , '$colorId' , '$sizeId' )";
    mysqli_query($conn , $query);
    return 1;
}

function updateCart($id , $prodcutId , $sizeId , $colorId){
    $conn = $GLOBALS['conn'];
    $cartId = ifIsset($id , $prodcutId , $sizeId , $colorId)['cartId'];
    $count = ifIsset($id , $prodcutId , $sizeId , $colorId)['count'];
    ++$count;
    $query = "UPDATE cart SET count = $count where cartId = '$cartId' ";
    mysqli_query($conn , $query);
}