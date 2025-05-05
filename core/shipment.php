<?php
include('validation.php');
include('config.php');
$_SESSION['error'] = [];
function shipMent($shipMentData){
    if(lengthIsrequered($shipMentData)){
        header("Location: ../checkout.php");
        exit;
    }
    if(minLengthFour($shipMentData)){
        header("Location: ../checkout.php");
        exit;
    }
    if(PhoneAndEmail($shipMentData)){
        header("Location: ../checkout.php");
        exit;
    }
    $query = "INSERT INTO shipment (name , email , address , phone , notes  , status) 
        value ('{$shipMentData['Name']}','{$shipMentData['Email']}','{$shipMentData['Address']}','{$shipMentData['Phone']}','{$shipMentData['Notes']}' , 'تم ارسال الطلب')";
    $res = mysqli_query($GLOBALS['conn'] , $query);
    $primaryId = $GLOBALS['conn']->insert_id;
    $updateCart = "UPDATE cart SET shipmentId = '$primaryId' WHERE userId = {$_SESSION['user']} and shipmentId = 0";
    mysqli_query($GLOBALS['conn'] , $updateCart);
    $_SESSION['error'] = [];
    header("Location: ../checkout.php");
    exit;
}

function lengthIsrequered($shipMentData){
    $isError = false;
    foreach($shipMentData as $field => $value){
        if(required($value , $field) != 1){
            $isError = true;
        }
        $_SESSION['error'] += [$field => [required($value , $field) , $value]];
    }
    return $isError;
}
function minLengthFour($shipMentData){
    $isError = false;
    foreach($shipMentData as $field => $value){
        if(length($value , $field) != 1){
            $isError = true;
        }
        $_SESSION['error'][$field] = [length($value , $field) , $value];
    }
    return $isError;
}

function PhoneAndEmail($shipMentData){
    $isError = false;
    if(isEmail($shipMentData['Email']) != 1){
        $isError = true;
    }
    $_SESSION['error']["Email"] = [isEmail($shipMentData['Email']) , $shipMentData['Email']];
    
    if(!is_numeric($shipMentData['Phone']) || $shipMentData['Phone'] < 999999999){
        $isError = true;
        $_SESSION['error']["Phone"] = ["Phone must be numeric and more than ten" , $shipMentData['Phone']];
    }else{
        $_SESSION['error']["Phone"] = [1 , $shipMentData['Phone']];
    }
    return $isError;
}