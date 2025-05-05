<?php
include('validation.php');
include('config.php');

$_SESSION['error'] = [];
function isRequired($ProductData){
    $isError = false;
    foreach($ProductData as $field => $value){
        if($field == 'category' || $field == 'ditials'){
            continue;
        }
        if(required($value , $field) != 1){
            $isError = true;
        }
        $_SESSION['error'] += [$field => [required($value , $field) , $value]];
    }
    if($ProductData['category'] == -1){
        $isError = true;
        $_SESSION['error'] += ['category' => ['please check a category' , $ProductData['category']]];
    }
    $_SESSION['error'] += ['category' => [1 , $ProductData['category']]];
    return $isError;
}

function lengthMoreFour($ProductData){

    $_SESSION['error'] = [];
    $isError = isNum($ProductData);
    foreach($ProductData as $field => $value){
        if($field == 'category' ||$field == 'Price' || $field == 'ditials'){
            $_SESSION['error'] += [$field => [1 , $value]];
            continue;
        }
        if(length($value , $field) != 1){
            $isError = true;
        }
        $_SESSION['error'] += [$field => [length($value , $field) , $value]];
    }
    return $isError;
}

function isNum($ProductData){
    $isError = false;
    if(!is_numeric($ProductData['Price']) || $ProductData['Price'] < 1){
        $_SESSION['error'] += ['Price' => ['this field must be numeric more than 0' , $ProductData['Price'] ]];
        $isError = true;
    }
    $_SESSION['error'] += ['Price' => [1 , $ProductData['Price'] ]];

    return $isError;
}
function image($ProductData){
    lengthMoreFour($ProductData);
    $isError = false;
    if(strlen($_FILES['image']['name']) == 0 ){
        $isError = true;
        $_SESSION['error'] += ['image' => ['please upload image', 1]];
    }

    return $isError;
}

function saveImage($ProductData){
    $name = (rand() . $_FILES['image']['name']);
    $ProductData += ['path' => $name];
    if(is_uploaded_file($_FILES['image']['tmp_name'])){
        $result = move_uploaded_file($_FILES['image']['tmp_name'] , '../images/' . basename($name));
    }
    return $ProductData;
}

function validation($ProductData){
    
    if(isRequired($ProductData)){
        header("Location: ../admin/CreateProduct.php");
        exit;
    }
    if(lengthMoreFour($ProductData)){
        header("Location: ../admin/CreateProduct.php");
        exit;
    }
    // exit;
    if(image($ProductData)){
        header("Location: ../admin/CreateProduct.php");
        exit;
    }
    detailCorect($ProductData);
    $ProductData = saveImage($ProductData);
    saveDataInDataBase($ProductData);
    header("Location: ../admin/CreateProduct.php");
    exit;
}

function saveDataInDataBase($ProductData){
    $userId = $_SESSION['user'];
    $ProductName = $_POST['ProductName'];
    $Price = $ProductData['Price'];
    $category = $ProductData['category'];
    $Description = $ProductData['Title'];
    $imagePath = $ProductData['path'];
    $haveDetails = empty($ProductData['ditials'])? 0 : 1;
    $query = "INSERT INTO products ( `userId`, `cateId`, `productName`, `price`, `discription` , `haveDetails`) VALUES
    ('$userId' , '$category' , '$ProductName' , '$Price' , '$Description' , '$haveDetails')";
    mysqli_query($GLOBALS['conn'] , $query);

    $primaryId = $GLOBALS['conn']->insert_id;
    // addDetails($ProductData , $primaryId);
    $query = "INSERT INTO `image` (productId ,imagePath ) VALUES ('$primaryId' , '$imagePath')";
    mysqli_query($GLOBALS['conn'] , $query);
}

function detailCorect($ProductData){
    if(empty($ProductData['ditials'])){
        return 1;
    }
    $detail = explode(',' , $ProductData['ditials']);

    $detailData = [];
    foreach($detail as $value){
        if(count(explode('-' , $value) ) == 4){
            $size =explode('-' , $value)[0];
            $color =explode('-' , $value)[1];
            $count =explode('-' , $value)[2];
            $colorHexCod =explode('-' , $value)[3];
        }else{
            $_SESSION['error'] += ['ditials' => ['Please write in the correct style.' , $ProductData['ditials']]];
            header("Location: ../admin/CreateProduct.php");
            exit;
        }
        
        $detailData[] =[
                'size' => $size,
                'color' => $color,
                'count' => $count,
                'colorHexCod' => $colorHexCod
        ];
    }
}
function addDetails($ProductData , $productId){
    if(empty($ProductData['ditials'])){
        return 1;
    }
    $detail = explode(',' , $ProductData['ditials']);
    echo '<pre>';
    print_r($detail);
    $detailData = [];
    foreach($detail as $value){
        $size =explode('-' , $value)[0];
        $color =explode('-' , $value)[1];
        $count =explode('-' , $value)[2];
        $colorHexCod =explode('-' , $value)[3];
        
        
        $detailData[] =[
                'size' => $size,
                'color' => $color,
                'count' => $count,
                'colorHexCod' => $colorHexCod
        ];
    }
    echo '<pre>';
    print_r($detailData);
    // exit;   
    foreach($detailData as $detailDat){
        $query = "INSERT INTO color (productId , colorName , colorHexCode) value ('$productId' , '{$detailDat['color']}' , '{$detailDat['colorHexCod']}')";
        mysqli_query($GLOBALS['conn'] , $query);
        $primaryId = 0;
        $primaryId = $GLOBALS['conn']->insert_id;
        $query = "INSERT INTO size (colorId , productId , sizeName , count) value ('$primaryId' , '$productId' , '{$detailDat['size']}' , '{$detailDat['count']}')";
        mysqli_query($GLOBALS['conn'] , $query);
    }
}